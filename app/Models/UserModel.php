<?php

declare(strict_types=1);

namespace WjCrypto\Models;

use WjCrypto\Models\CoreModel;

/**
 * UserModel
 */
class UserModel extends CoreModel{  
  private $userId;
  private $acc_number;
  private $password;
  private $name;
  private $dob;
  private $phone;
  private $document_number;
  private $company_registration;
  private $company_foundation;

  public function __construct()
  {
    parent::__construct();
    parent::setAttributes(
      "wj_crypto.user",
      [
        "user_id",
        "acc_number",
        "password",
        "name",
        "dob",
        "phone",
        "document_number",
        "company_registration",
        "company_foundation"
      ]
    );
  }

  /**
   * Get the value of userId
   */ 
  public function getUserId()
  {
    return $this->userId;
  }

  /**
   * Set the value of userId
   *
   * @return  self
   */ 
  public function setUserId($userId)
  {
    $this->userId = $userId;

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
   * Get the value of password
   */ 
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   *
   * @return  self
   */ 
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }

  /**
   * Get the value of name
   */ 
  public function getName()
  {
    return $this->name;
  }

  /**
   * Set the value of name
   *
   * @return  self
   */ 
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * Get the value of dob
   */ 
  public function getDob()
  {
    return $this->dob;
  }

  /**
   * Set the value of dob
   *
   * @return  self
   */ 
  public function setDob($dob)
  {
    $this->dob = $dob;

    return $this;
  }

  /**
   * Get the value of phone
   */ 
  public function getPhone()
  {
    return $this->phone;
  }

  /**
   * Set the value of phone
   *
   * @return  self
   */ 
  public function setPhone($phone)
  {
    $this->phone = $phone;

    return $this;
  }

  /**
   * Get the value of document_number
   */ 
  public function getDocumentNumber()
  {
    return $this->document_number;
  }

  /**
   * Set the value of document_number
   *
   * @return  self
   */ 
  public function setDocumentNumber($document_number)
  {
    $this->document_number = $document_number;

    return $this;
  }

  /**
   * Get the value of company_registration
   */ 
  public function getCompanyRegistration()
  {
    return $this->company_registration;
  }

  /**
   * Set the value of company_registration
   *
   * @return  self
   */ 
  public function setCompanyRegistration($company_registration)
  {
    $this->company_registration = $company_registration;

    return $this;
  }

  /**
   * Get the value of company_foundation
   */ 
  public function getCompanyFoundation()
  {
    return $this->company_foundation;
  }

  /**
   * Set the value of company_foundation
   *
   * @return  self
   */ 
  public function setCompanyFoundation($company_foundation)
  {
    $this->company_foundation = $company_foundation;

    return $this;
  }
}
