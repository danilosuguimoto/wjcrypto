<?php

declare(strict_types=1);

namespace WjCrypto\Controllers\API;

use Exception;
use Helper;
use WjCrypto\Models\UserAddressModel;
use WjCrypto\Models\UserModel;

class UserApiController 
{
  private UserModel $user;
  private UserAddressModel $userAddress;

  public function __construct() 
  {
    $this->user = Helper::getContainer('UserModel');
  }

  /**
   * searchAllUsers
   *
   * @return string
   */
  public function searchAllUsers() 
  {
    $allUsers = $this->user->selectAllData();

    $this->userAddress = Helper::getContainer('UserAddressModel');

    $length = 0;

    foreach($allUsers as $user) {
      $data[$length] = [
        'user' => $user,
        'address' => $this->userAddress->selectDataFrom('acc_number', $user->acc_number)[0]
      ];

      $length++;
    }
    
    Helper::apiResponse(
      $this->user::USER_SEARCH_SUCCESS,
      'users',
      $data
    );
  }

  /**
   * searchUserByAccNumber
   *
   * @param  string $accNumber
   * @return string
   */
  public function searchUserByAccNumber(string $accNumber) 
  {
    $user = $this->user->selectDataFrom('acc_number', $accNumber);
    
    if($user == false) {
      http_response_code(404);
      $message = $this->user::USER_NOT_FOUND . " (Conta: $accNumber)";
    } else {
      $message = $this->user::USER_SEARCH_SUCCESS . " (Conta: $accNumber)";
    }

    $this->userAddress = Helper::getContainer('UserAddressModel');

    $address = $this->userAddress->selectDataFrom('acc_number', $user[0]->acc_number);

    $data = [
      'user' => $user[0],
      'address' => $address[0]
    ];

    Helper::apiResponse(
      $message,
      'search_result',
      $data
    );
  }

  /**
   * authenticate
   *
   * Authenticates the given user
   * 
   * @return void
   */
  public function authenticate() 
  {
    $request_content = json_decode(file_get_contents('php://input'));

    $loginData = [
      'acc_number' => $request_content->acc_number,
      'password' => $request_content->password
    ];

    $user = $this->user->selectDataFrom('acc_number', $loginData['acc_number']);
    $validateLoginData = $this->user->validateLoginData($loginData, $user[0]);

    switch($validateLoginData) {
      case $this->user::USER_NOT_FOUND:
        http_response_code(404);
        $message = $this->user::USER_NOT_FOUND;
        break;

      case $this->user::USER_WRONG_PASSWORD:
        http_response_code(401);
        $message = $this->user::USER_WRONG_PASSWORD;
        break;

      case $this->user::USER_AUTHENTICATION_SUCCESS:
        $message = $this->user::USER_AUTHENTICATION_SUCCESS;
        $this->user->setAuthenticationToken(base64_encode(random_bytes(16)));
        break;
    }

    $token = $this->user->getAuthenticationToken();

    $data = ['authentication_token' => $token];

    if(isset($token)) {
      $this->user->updateData($data, 'acc_number', $loginData['acc_number']);

      Helper::apiResponse(
        $message,
        'authentication_token',
        $token
      );
    } else {
      Helper::apiResponse($message);
    }
  }

  /**
   * createUser
   *
   * Creates a new user based on the data received from the API
   * 
   * @return string
   */
  public function createUser() 
  {
    $request_content = json_decode(file_get_contents('php://input'));
    $allUsers = $this->user->selectAllData();

    try {
      // Checking all attributes length
      foreach($request_content->user as $param => $value) {
        if(strlen($value) > 256) {
          http_response_code(400);

          throw new Exception('O número de caracteres no campo ' . $param . ' não deve ser maior que 256.');
        }
      }

      foreach($request_content->address as $param => $value) {
        if(strlen($value) > 256) {
          http_response_code(400);

          throw new Exception('O número de caracteres no campo ' . $param . ' não deve ser maior que 256.');
        }
      }

      $accNumber = md5(openssl_random_pseudo_bytes(4));

      $uniqueAttributes = [
        $accNumber,
        $request_content->user->document_number,
      ];

      // If there were any users previously created, checks wether the given unique attributes does not exist in the database already 
      if(!empty($allUsers)) {
        foreach($uniqueAttributes as $uniqueAttribute) {
          $isValid = $this->user->validateUniqueData($uniqueAttribute);
  
          if($isValid != $this->user::USER_VALID_DATA) {
            http_response_code(400);
            
            throw new Exception($isValid);
          }
        }
      }
      
      $password = password_hash($request_content->user->password, PASSWORD_ARGON2I);

      $this->user->setAccNumber($accNumber);
      $this->user->setPassword($password);
      $this->user->setName(Helper::encrypt_data($request_content->user->name));
      $this->user->setDob(Helper::encrypt_data($request_content->user->dob));
      $this->user->setPhone(Helper::encrypt_data($request_content->user->phone));
      $this->user->setDocumentNumber(Helper::encrypt_data($request_content->user->document_number));
      $this->user->setBalance(0);

      $userData = [
        'acc_number' => $this->user->getAccNumber(),
        'password' => $this->user->getPassword(),
        'name' => $this->user->getName(),
        'dob' => $this->user->getDob(),
        'phone' => $this->user->getPhone(),
        'document_number' => $this->user->getDocumentNumber(),
        'balance' => $this->user->getBalance()
      ];

      $this->user->insertData($userData);

      $this->userAddress = Helper::getContainer('UserAddressModel');

      $this->userAddress->setCountry(Helper::encrypt_data($request_content->address->country));
      $this->userAddress->setRegion(Helper::encrypt_data($request_content->address->region));
      $this->userAddress->setPostcode(Helper::encrypt_data($request_content->address->postcode));
      $this->userAddress->setCity(Helper::encrypt_data($request_content->address->city));
      $this->userAddress->setStreet(Helper::encrypt_data($request_content->address->street));

      $addressData = [
        'acc_number' => $this->user->getAccNumber(),
        'country' => $this->userAddress->getCountry(),
        'region' => $this->userAddress->getRegion(),
        'postcode' => $this->userAddress->getPostcode(),
        'city' => $this->userAddress->getCity(),
        'street' => $this->userAddress->getStreet(),
      ];

      $this->userAddress->insertData($addressData);

      http_response_code(201);

      $message = $this->user::USER_CREATION_SUCCESS;
    } catch (Exception $e) {
      $message = $e->getMessage();
      Helper::apiResponse($message);
    }

    Helper::apiResponse(
      $message,
      'acc_number',
      $this->user->getAccNumber()
    );
  }
  
  /**
   * updateBalance
   *
   * Updates the account balance through the API data
   * 
   * @return void
   */
  public function updateBalance()
  {
    $request_content = json_decode(file_get_contents('php://input'));

    $this->user->setBalance($request_content->balance);

    $data = ['balance' => $this->user->getBalance()];

    $this->user->updateData($data, 'acc_number', $request_content->acc_number);
  }

  public function getAccBalance()
  {
    $request_content = json_decode(file_get_contents('php://input'));

    $acc = $this->user->selectDataFrom('acc_number', $request_content->acc_number);

    $balance = $acc[0]->balance;

    Helper::apiResponse(
      'Busca realizada com sucesso!',
      'balance',
      $balance
    );
  }
}
