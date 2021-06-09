<?php

declare(strict_types=1);

namespace WjCrypto\Models;

use WjCrypto\Models\CoreModel;

/**
 * TransactionModel
 */
class TransactionModel extends CoreModel 
{
  public const TRANSACTION_DEPOSIT_SUCCESS = 'Depósito realizado com sucesso!';
  public const TRANSACTION_WITHDRAW_SUCCESS = 'Saque realizado com sucesso!';
  public const TRANSACTION_TRANSFER_SUCCESS = 'Transferência realizada com sucesso!';
  public const TRANSACTION_INSUFFICIENT_BALANCE = 'Você não possui saldo suficiente para esta transação.';
  public const TRANSACTION_ACC_NUMBER_NOT_FOUND = 'O número da conta informada não existe.';

  private $transaction_id;
  private $acc_number;
  private $amount;
  private $type;
  private $created_at;
  private $from_acc;
  private $to_acc;

  public function __construct()
  {
    parent::setAttributes(
      "wj_crypto.transactions",
      [
        "transaction_id",
        "acc_number",
        "amount",
        "balance",
        "type",
        "created_at",
        "from_acc",
        "to_acc"
      ]
    );
  }
  
  /**
   * Get the value of transaction_id
   */ 
  public function getTransactionId()
  {
    return $this->transaction_id;
  }

  /**
   * Set the value of transaction_id
   *
   * @return  self
   */ 
  public function setTransactionId($transaction_id)
  {
    $this->transaction_id = $transaction_id;

    return $this;
  }

  /**
   * Get the value of acc_number
   */ 
  public function getAccNumber()
  {
    return $this->acc_number;
  }

  /**
   * Set the value of acc_number
   *
   * @return  self
   */ 
  public function setAccNumber($acc_number)
  {
    $this->acc_number = $acc_number;

    return $this;
  }

  /**
   * Get the value of amount
   */ 
  public function getAmount()
  {
    return $this->amount;
  }

  /**
   * Set the value of amount
   *
   * @return  self
   */ 
  public function setAmount($amount)
  {
    $this->amount = $amount;

    return $this;
  }

  /**
   * Get the value of balance
   */ 
  public function getBalance()
  {
    return $this->balance;
  }

  /**
   * Set the value of balance
   *
   * @return  self
   */ 
  public function setBalance($balance)
  {
    $this->balance = $balance;

    return $this;
  }

  /**
   * Get the value of type
   */ 
  public function getType()
  {
    return $this->type;
  }

  /**
   * Set the value of type
   *
   * @return  self
   */ 
  public function setType($type)
  {
    $this->type = $type;

    return $this;
  }

  /**
   * Get the value of created_at
   */ 
  public function getCreatedAt()
  {
    return $this->created_at;
  }

  /**
   * Set the value of created_at
   *
   * @return  self
   */ 
  public function setCreatedAt($created_at)
  {
    $this->created_at = $created_at;

    return $this;
  }

  /**
   * Get the value of from_acc
   */ 
  public function getFromAcc()
  {
    return $this->from_acc;
  }

  /**
   * Set the value of from_acc
   *
   * @return  self
   */ 
  public function setFromAcc($from_acc)
  {
    $this->from_acc = $from_acc;

    return $this;
  }

  /**
   * Get the value of to_acc
   */ 
  public function getToAcc()
  {
    return $this->to_acc;
  }

  /**
   * Set the value of to_acc
   *
   * @return  self
   */ 
  public function setToAcc($to_acc)
  {
    $this->to_acc = $to_acc;

    return $this;
  }
}
