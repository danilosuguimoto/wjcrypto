<?php

declare(strict_types=1);

namespace WjCrypto\Models;

use Helper;
use WjCrypto\Models\CoreModel;

/**
 * UserModel
 */
class UserModel extends CoreModel 
{
  public const USER_ACCNUMBER_ALREADY_EXISTS = 'O número da conta informada já existe.';
  public const USER_AUTHENTICATION_SUCCESS = 'Autenticação realizada com sucesso!';
  public const USER_AUTHENTICATION_FAIL = 'O token informado está incorreto.';
  public const USER_CREATION_SUCCESS = 'Usuário criado com sucesso!';
  public const USER_DOCUMENT_NUMBER_ALREADY_EXISTS = 'O número do CPF/CNPJ informado já foi utilizado.';
  public const USER_NOT_FOUND = 'Usuário não encontrado.';
  public const USER_SEARCH_SUCCESS = 'Busca realizada com sucesso!';
  public const USER_VALID_DATA = 'Checagem de dados OK!';
  public const USER_WRONG_PASSWORD = 'A senha informada está incorreta.';

  private $userId;
  private $accNumber;
  private $password;
  private $name;
  private $dob;
  private $phone;
  private $documentNumber;
  private $authenticationToken;
  private $balance;

  public function __construct()
  {
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
        "authentication_token",
        "balance"
      ]
    );
  }

  /**
   * validateLoginData
   *
   * Checks if the given acc_number exists and if the given password matches the stored hashed password
   * 
   * @param  array $loginData
   * @param  object|bool $userData
   * @return string
   */
  public function validateLoginData(array $loginData, $userData)
  {
    if(!$userData) {
      return self::USER_NOT_FOUND;
    }

    $isPasswordCorrect = password_verify($loginData['password'], $userData->password);

    if(!$isPasswordCorrect) {
      return self::USER_WRONG_PASSWORD;
    }
    
    return self::USER_AUTHENTICATION_SUCCESS;
  }
  
  /**
   * validateUniqueData
   *
   * Checks wether the given data matches unique data stored in the database
   * 
   * @param  string $data
   * @return string
   */
  public function validateUniqueData(string $data)
  {
    $users = self::selectAllData();

    foreach($users as $user) {
      switch($data) {
        case $user->acc_number:
          $message = self::USER_ACCNUMBER_ALREADY_EXISTS;
          break;
        case Helper::decrypt_data($user->document_number):
          $message = self::USER_DOCUMENT_NUMBER_ALREADY_EXISTS;
          break;
        default:
          $message = self::USER_VALID_DATA;
          break;
      }
    }

    return $message;
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
   * Get the value of accNumber
   */ 
  public function getAccNumber()
  {
    return $this->accNumber;
  }

  /**
   * Set the value of accNumber
   *
   * @return  self
   */ 
  public function setAccNumber($accNumber)
  {
    $this->accNumber = $accNumber;

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
   * Get the value of documentNumber
   */ 
  public function getDocumentNumber()
  {
    return $this->documentNumber;
  }

  /**
   * Set the value of documentNumber
   *
   * @return  self
   */ 
  public function setDocumentNumber($documentNumber)
  {
    $this->documentNumber = $documentNumber;

    return $this;
  }

  /**
   * Get the value of authentication_token
   */
  public function getAuthenticationToken()
  {
    return $this->authenticationToken;
  }

  /**
   * Set the value of authenticationToken
   *
   * @return  self
   */ 
  public function setAuthenticationToken($authenticationToken)
  {
    $this->authenticationToken = $authenticationToken;

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
}
