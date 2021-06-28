<?php

declare(strict_types=1);

namespace WjCrypto\Controllers\API;

use Exception;
use Helper;
use WjCrypto\Models\TransactionModel;

class TransactionApiController 
{
  private TransactionModel $transaction;
  
  public function __construct()
  {
    $this->transaction = Helper::getContainer('TransactionModel');
  }

  public function getAccBalance(string $accNumber)
  {
    $result = Helper::getApiConnection('/users/getAccBalance', ['acc_number' => $accNumber]);

    $balance = $result->balance;
    
    return $balance;
  }

  /**
   * deposit
   *
   * Deposits the given amount in the specified account
   * 
   * @return void
   */
  public function deposit()
  {
    $request_content = json_decode(file_get_contents('php://input'));

    $depositData = [
      'acc_number' => $request_content->acc_number,
      'deposit_amount' => $request_content->deposit_amount
    ];

    $oldBalance = $this->getAccBalance($depositData['acc_number']);
    $newBalance = $oldBalance + $depositData['deposit_amount'];

    $this->transaction->setAccNumber($depositData['acc_number']);
    $this->transaction->setAmount($depositData['deposit_amount']);
    $this->transaction->setBalance($newBalance);
    $this->transaction->setType('deposit');
    $this->transaction->setCreatedAt(date('Y-m-d H:i:s'));
    $this->transaction->setFromAcc($depositData['acc_number']);
    $this->transaction->setToAcc($depositData['acc_number']);

    $transactionData = [
      'acc_number' => $this->transaction->getAccNumber(),
      'amount' => $this->transaction->getAmount(),
      'balance' => $this->transaction->getBalance(),
      'type' => $this->transaction->getType(),
      'created_at' => $this->transaction->getCreatedAt(),
      'from_acc' => $this->transaction->getFromAcc(),
      'to_acc' => $this->transaction->getToAcc()
    ];

    // Inserting the transaction data in the database
    $this->transaction->insertData($transactionData);

    Helper::getApiConnection(
      '/users/updateBalance',
      [
        'acc_number' => $this->transaction->getAccNumber(),
        'balance' => $this->transaction->getBalance()
      ],
      false
    );

    $message = $this->transaction::TRANSACTION_DEPOSIT_SUCCESS;

    Helper::apiResponse(
      $message,
      'transaction_data',
      $transactionData
    );
  }
  
  /**
   * withdraw
   *
   * Withdraws the given amount in the specified account
   * 
   * @return void
   */
  public function withdraw()
  {
    $request_content = json_decode(file_get_contents('php://input'));

    $withdrawData = [
      'acc_number' => $request_content->acc_number,
      'withdraw_amount' => $request_content->withdraw_amount
    ];

    try {
      $oldBalance = $this->getAccBalance($withdrawData['acc_number']);
      $newBalance = $oldBalance - $withdrawData['withdraw_amount'];

      if($newBalance <= -1) {
        throw new Exception($this->transaction::TRANSACTION_INSUFFICIENT_BALANCE);
      }

      $this->transaction->setAccNumber($withdrawData['acc_number']);
      $this->transaction->setAmount($withdrawData['withdraw_amount']);
      $this->transaction->setBalance($newBalance);
      $this->transaction->setType('withdraw');
      $this->transaction->setCreatedAt(date('Y-m-d H:i:s'));
      $this->transaction->setFromAcc($withdrawData['acc_number']);
      $this->transaction->setToAcc($withdrawData['acc_number']);

      $transactionData = [
        'acc_number' => $this->transaction->getAccNumber(),
        'amount' => $this->transaction->getAmount(),
        'balance' => $this->transaction->getBalance(),
        'type' => $this->transaction->getType(),
        'created_at' => $this->transaction->getCreatedAt(),
        'from_acc' => $this->transaction->getFromAcc(),
        'to_acc' => $this->transaction->getToAcc()
      ];

      // Inserting the transaction data in the database
      $this->transaction->insertData($transactionData);

      Helper::getApiConnection(
        '/users/updateBalance',
        [
          'acc_number' => $this->transaction->getAccNumber(),
          'balance' => $this->transaction->getBalance()
        ],
        false
      );

      $message = $this->transaction::TRANSACTION_WITHDRAW_SUCCESS;

      Helper::apiResponse(
        $message,
        'transaction_data',
        $transactionData
      );
    } catch (Exception $e) {
      $message = $e->getMessage();
      http_response_code(400);
      Helper::apiResponse($message);
    }
  }

  public function transfer()
  {
    $request_content = json_decode(file_get_contents('php://input'));

    $transferData = [
      'from_acc_number' => $request_content->from_acc_number,
      'to_acc_number' => $request_content->to_acc_number,
      'transfer_amount' => $request_content->transfer_amount
    ];

    try {
      // Withdrawing amount from the sender account
      $fromAccOldBalance = $this->getAccBalance($transferData['from_acc_number']);
      $fromAccNewBalance = $fromAccOldBalance - $transferData['transfer_amount'];

      if($fromAccNewBalance < 0) {
        throw new Exception($this->transaction::TRANSACTION_INSUFFICIENT_BALANCE);
      }

      $this->transaction->setAccNumber($transferData['from_acc_number']);
      $this->transaction->setAmount($transferData['transfer_amount']);
      $this->transaction->setBalance($fromAccNewBalance);
      $this->transaction->setType('transfer_withdraw');
      $this->transaction->setCreatedAt(date('Y-m-d H:i:s'));
      $this->transaction->setFromAcc($transferData['from_acc_number']);
      $this->transaction->setToAcc($transferData['to_acc_number']);

      $xTransactionData = [
        'acc_number' => $this->transaction->getAccNumber(),
        'amount' => $this->transaction->getAmount(),
        'balance' => $this->transaction->getBalance(),
        'type' => $this->transaction->getType(),
        'created_at' => $this->transaction->getCreatedAt(),
        'from_acc' => $this->transaction->getFromAcc(),
        'to_acc' => $this->transaction->getToAcc()
      ];

      // Inserting the transaction data in the database
      $this->transaction->insertData($xTransactionData);

      Helper::getApiConnection(
        '/users/updateBalance',
        [
          'acc_number' => $this->transaction->getAccNumber(),
          'balance' => $this->transaction->getBalance()
        ],
        false
      );

      // Sending amount to the recipient account
      $ToAccOldBalance = $this->getAccBalance($transferData['to_acc_number']);
      $ToAccNewBalance = $ToAccOldBalance + $transferData['transfer_amount'];

      $this->transaction->setAccNumber($transferData['to_acc_number']);
      $this->transaction->setAmount($transferData['transfer_amount']);
      $this->transaction->setBalance($ToAccNewBalance);
      $this->transaction->setType('transfer_deposit');
      $this->transaction->setCreatedAt(date('Y-m-d H:i:s'));
      $this->transaction->setFromAcc($transferData['from_acc_number']);
      $this->transaction->setToAcc($transferData['to_acc_number']);

      $yTransactionData = [
        'acc_number' => $this->transaction->getAccNumber(),
        'amount' => $this->transaction->getAmount(),
        'balance' => $this->transaction->getBalance(),
        'type' => $this->transaction->getType(),
        'created_at' => $this->transaction->getCreatedAt(),
        'from_acc' => $this->transaction->getFromAcc(),
        'to_acc' => $this->transaction->getToAcc()
      ];

      // Inserting the transaction data in the database
      $this->transaction->insertData($yTransactionData);

      Helper::getApiConnection(
        '/users/updateBalance',
        [
          'acc_number' => $this->transaction->getAccNumber(),
          'balance' => $this->transaction->getBalance()
        ],
        false
      );

      $message = $this->transaction::TRANSACTION_TRANSFER_SUCCESS;

      $responseData = [
        'sender_data' => [
          'acc_number' => $transferData['from_acc_number'],
          'new_balance' => $xTransactionData['balance']
        ],
        'recipient_data' => [
          'acc_number' => $transferData['to_acc_number'],
          'new_balance' => $yTransactionData['balance']
        ]
      ];

      Helper::apiResponse(
        $message,
        'transaction_data',
        $responseData
      );
    } catch (Exception $e) {
      $message = $e->getMessage();
      Helper::apiResponse($message);
    }
  }
}
