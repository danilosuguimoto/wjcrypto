<?php

declare(strict_types=1);

namespace WjCrypto\Models;

use WjCrypto\Models\CoreModel;

/**
 * UserAddressModel
 */
class UserAddressModel extends CoreModel {
  private $action_id;
  private $acc_number;
  private $action_type;
  private $created_at;
  private $is_error;

  public function __construct()
  {
    parent::setAttributes(
      "wj_crypto.actions_log",
      [
        "action_id",
        "acc_number",
        "action_type",
        "created_at",
        "is_error"
      ]
    );
  }

  /**
   * Get the value of action_id
   */ 
  public function getActionId()
  {
    return $this->action_id;
  }

  /**
   * Set the value of action_id
   *
   * @return  self
   */ 
  public function setActionId($action_id)
  {
    $this->action_id = $action_id;

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
   * Get the value of action_type
   */ 
  public function getActionType()
  {
    return $this->action_type;
  }

  /**
   * Set the value of action_type
   *
   * @return  self
   */ 
  public function setActionType($action_type)
  {
    $this->action_type = $action_type;

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
   * Get the value of is_error
   */ 
  public function getIsError()
  {
    return $this->is_error;
  }

  /**
   * Set the value of is_error
   *
   * @return  self
   */ 
  public function setIsError($is_error)
  {
    $this->is_error = $is_error;

    return $this;
  }
}
