<?php

declare(strict_types=1);

namespace WjCrypto\Controllers\API;

use Helper;
use WjCrypto\Models\UserModel;

class UserApiController {
  protected $userModel;
  protected $blade;
    
  /**
   * __construct
   *
   * Sets a unique instance of UserModel and ViewManager whenever an object is created
   * 
   * @return void
   */
  public function __construct() {
    $this->userModel = new UserModel();
  }

  /**
   * getAllUsers
   * 
   * Returns a JSON list of all registred users in the system
   *
   * @return string
   */
  public function getAllUsers() {
    $data = [
      'users' => $this->userModel->selectAllData()
    ];

    Helper::response()->json(
      $data, 
      JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );
  }
  
  /**
   * getUserById
   *
   * Returns a JSON containing all data from the specified user
   * 
   * @param  int $id
   * @return string
   */
  public function getUserById(int $id) {
    $data = $this->userModel->selectDataFrom($id);

    Helper::response()->json(
      $data, 
      JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );
  }

  /**
   * createUser
   *
   * Creates a new user based on the information coming from the API/frontend
   * 
   * @return void
   */
  public function createUser() {
    $password = password_hash('Senha1234', PASSWORD_ARGON2I);

    Helper::request();

    $this->userModel->setAccNumber('dasjkgffhkj_dd1331234');
    $this->userModel->setPassword($password);
    $this->userModel->setName('Danilo Suguimoto');
    $this->userModel->setDob('2001-08-06');
    $this->userModel->setPhone('(11) 95270-6609');
    $this->userModel->setDocumentNumber('43212715847');

    $data = [
      'acc_number' => $this->userModel->getAccNumber(),
      'password' => $this->userModel->getPassword(),
      'name' => $this->userModel->getName(),
      'dob' => $this->userModel->getDob(),
      'phone' => $this->userModel->getPhone(),
      'document_number' => $this->userModel->getDocumentNumber()
    ];

    $this->userModel->insertData($data);

    echo 'User Created Succesfully';
  }
}
