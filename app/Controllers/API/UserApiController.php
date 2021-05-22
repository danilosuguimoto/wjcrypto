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
    $request_content = json_decode(file_get_contents('php://input'));

    $password = password_hash($request_content->password, PASSWORD_ARGON2I);

    $this->userModel->setAccNumber($request_content->acc_number);
    $this->userModel->setPassword($password);
    $this->userModel->setName($request_content->name);
    $this->userModel->setDob($request_content->dob);
    $this->userModel->setPhone($request_content->phone);
    $this->userModel->setDocumentNumber($request_content->document_number);

    $data = [
      'acc_number' => $this->userModel->getAccNumber(),
      'password' => $this->userModel->getPassword(),
      'name' => $this->userModel->getName(),
      'dob' => $this->userModel->getDob(),
      'phone' => $this->userModel->getPhone(),
      'document_number' => $this->userModel->getDocumentNumber()
    ];

    $this->userModel->insertData($data);

    return Helper::response()->json(
      ["message" => "Usuário criado com sucesso"]
    );
  }
}
