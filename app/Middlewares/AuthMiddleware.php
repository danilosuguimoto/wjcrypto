<?php

namespace WjCrypto\Middlewares;

use Helper;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use WjCrypto\Models\UserModel;

class AuthMiddleware implements IMiddleware
{
  private UserModel $userModel;

  public function __construct() 
  {
    $this->userModel = Helper::getContainer('UserModel');
  }

  public function handle(Request $request): void 
  {
    $authentication_token = $_SESSION['authentication_token'];

    $user = $this->userModel->selectDataFrom('acc_number', $_SESSION['acc_number']);

    if(empty($authentication_token) || $authentication_token != $user[0]->authentication_token) {
      header('WWW-Authenticate: Bearer realm="Access Denied"');
      http_response_code(401);

      Helper::response()->redirect('/');
    } else {
      header('WWW-Authenticate: Bearer ' . $authentication_token);
      http_response_code(200);
    }
  }
}