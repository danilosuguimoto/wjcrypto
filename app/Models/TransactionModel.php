<?php

declare(strict_types=1);

namespace WjCrypto\Models;

use WjCrypto\Models\CoreModel;

/**
 * TransactionModel
 */
class TransactionModel extends CoreModel {
  private $transaction_id;
  private $acc_number;
  private $type;
  private $created_at;
  private $from_acc;
  private $to_acc;
  
  /**
   * transactionAttributes
   *
   * @return void
   */
  public function transactionAttributes() {
    $this->setAttributes(
      "wj_crypto.transactions",
      [
        "transaction_id",
        "acc_number",
        "type",
        "created_at",
        "from_acc",
        "to_acc"
      ]
    );
  }
    
  /**
   * selectAllTransactionsData
   *
   * @return array
   */
  public function selectAllTransactionsData() {
    return $this->selectAllData();
  }
    
  /**
   * selectDataFromTransactionId
   *
   * @param  int $id
   * @return array
   */
  public function selectDataFromTransactionId($id) {
    return $this->selectDataFrom($id);
  }
      
  /**
   * addTransactionData
   *
   * @param  array $data
   * @return void
   */
  public function addTransactionData(array $data) {
    $this->insertData($data);
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
