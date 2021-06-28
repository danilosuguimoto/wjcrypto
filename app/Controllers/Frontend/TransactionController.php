<?php

declare(strict_types=1);

namespace WjCrypto\Controllers\Frontend;

use Helper;
use Jenssegers\Blade\Blade;
use WjCrypto\Models\TransactionModel;

/**
 * TransactionController
 */
class TransactionController
{
  private Blade $view;
  private TransactionModel $transaction;

  public function __construct()
  {
    $this->view = Helper::getContainer('ViewManager')->getViewObject();
    $this->transaction = Helper::getContainer('TransactionModel');
  }

  public function deposit()
  {
    $data = [
      'acc_number' => $_SESSION['acc_number'],
      'deposit_amount' => filter_input(INPUT_POST, 'deposit_amount', FILTER_SANITIZE_STRING)
    ];

    $result = Helper::getApiConnection('/transactions/deposit', $data);

    $this->showDepositPage($result->message, $result->transaction_data->balance);
  }

  public function withdraw()
  {
    $data = [
      'acc_number' => $_SESSION['acc_number'],
      'withdraw_amount' => filter_input(INPUT_POST, 'withdraw_amount', FILTER_SANITIZE_STRING)
    ];

    $result = Helper::getApiConnection('/transactions/withdraw', $data);

    if($result->message == $this->transaction::TRANSACTION_INSUFFICIENT_BALANCE) {
      $this->showWithdrawPage($result->message);
    } else {
      $this->showWithdrawPage($result->message, $result->transaction_data->balance);
    }
  }

  public function transfer()
  {
    $data = [
      'from_acc_number' => $_SESSION['acc_number'],
      'to_acc_number' => filter_input(INPUT_POST, 'to_acc_number', FILTER_SANITIZE_STRING),
      'transfer_amount' => filter_input(INPUT_POST, 'transfer_amount', FILTER_SANITIZE_STRING)
    ];

    $result = Helper::getApiConnection('/transactions/transfer', $data);

    if($result->message == $this->transaction::TRANSACTION_INSUFFICIENT_BALANCE) {
      $this->showTransferPage($result->message);
    } else {
      $this->showTransferPage($result->message, $result->transaction_data->sender_data->new_balance);
    }
  }

  public function showDepositPage($message = null, $newBalance = null)
  {
    $this->balance = Helper::getUserBalance();

    if(!empty($message) && !empty($newBalance)) {
      echo $this->view->render(
        'pages/deposit',
        [
          'balance' => $newBalance,
          'message' => $message
        ]
      );
    } elseif(!empty($message) && empty($newBalance)) {
      echo $this->view->render(
        'pages/deposit',
        [
          'balance' => $this->balance,
          'message' => $message
        ]
      );
    } else {
      echo $this->view->render('pages/deposit', ['balance' => $this->balance]);
    }
  }

  public function showWithdrawPage($message = null, $newBalance = null)
  {
    $this->balance = Helper::getUserBalance();

    if(!empty($message) && isset($newBalance)) {
      echo $this->view->render(
        'pages/withdraw',
        [
          'balance' => $newBalance,
          'message' => $message
        ]
      );
    } elseif(!empty($message) && empty($newBalance)) {
      echo $this->view->render(
        'pages/withdraw',
        [
          'balance' => $this->balance,
          'message' => $message
        ]
      );
    } else {
      echo $this->view->render('pages/withdraw', ['balance' => $this->balance]);
    }
  }

  public function showTransferPage($message = null, $newBalance = null)
  {
    $this->balance = Helper::getUserBalance();

    if(!empty($message) && !empty($newBalance)) {
      echo $this->view->render(
        'pages/transfer',
        [
          'balance' => $newBalance,
          'message' => $message
        ]
      );
    } elseif(!empty($message) && empty($newBalance)) {
      echo $this->view->render(
        'pages/transfer',
        [
          'balance' => $this->balance,
          'message' => $message
        ]
      );
    } else {
      echo $this->view->render('pages/transfer', ['balance' => $this->balance]);
    }
  }

  public function showBalancePage($message = null)
  {
    $transactions = $this->transaction->selectDataFrom('acc_number', $_SESSION['acc_number']);

    $this->balance = Helper::getUserBalance();

    if(empty($transactions)) {
      $message = 'Nenhuma transação encontrada.';

      echo $this->view->render(
        'pages/balance',
        [
          'message' => $message,
          'balance' => $this->balance,
        ]
      );
    } else {
      echo $this->view->render(
        'pages/balance',
        [
          'transactions' => $transactions,
          'balance' => $this->balance,
        ]
      );
    }
  }
}
