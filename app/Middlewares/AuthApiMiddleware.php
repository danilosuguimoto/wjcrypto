<?php

namespace WjCrypto\Middlewares;

use Exception;
use Helper;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use WjCrypto\Models\UserModel;

class AuthApiMiddleware implements IMiddleware
{
  private UserModel $userModel;

  public function __construct() 
  {
    $this->userModel = Helper::getContainer('UserModel');
  }

  public function handle(Request $request): void
  {
    $authentication_header = $request->getHeader('authorization');
    $authentication_token = substr($authentication_header, 7);

    try {
      $user = $this->userModel->selectDataFrom('authentication_token', $authentication_token);

      if($user != false) {
        if(empty($authentication_token) || $authentication_token != $user[0]->authentication_token) {
          header('WWW-Authenticate: Bearer realm="Access Denied"');
          http_response_code(401);

          Helper::apiResponse('Acesso negado - Token vazio ou incorreto');
        } else {
          header('WWW-Authenticate: Bearer ' . $authentication_token);
          http_response_code(200);
        }
      } else {
        throw new Exception('Nenhum usuário corresponde com o token informado.');
      }
    } catch (Exception $e) {
      $message = $e->getMessage();

      header('WWW-Authenticate: Bearer realm="Access Denied"');
      http_response_code(401);

      Helper::apiResponse('Acesso negado - ' . $message);
    }
  }
}
