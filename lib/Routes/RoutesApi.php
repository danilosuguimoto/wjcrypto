<?php

declare(strict_types=1);

use Pecee\SimpleRouter\SimpleRouter;
use WjCrypto\Controllers\API\TransactionApiController;
use WjCrypto\Controllers\API\UserApiController;

SimpleRouter::group(['namespace' => 'WjCrypto\Controllers\API', 'prefix' => '/rest/API'], function() {
  //Authentication
  SimpleRouter::post('/authentication', [UserApiController::class, 'authenticate']);
  //Create new user
  SimpleRouter::post('/users/create', [UserApiController::class, 'createUser']);

  SimpleRouter::post('/users/getAccBalance', [UserApiController::class, 'getAccBalance']);
  SimpleRouter::post('/users/updateBalance', [UserApiController::class, 'updateBalance']);

  //Need Authentication
  SimpleRouter::group(['middleware' => WjCrypto\Middlewares\AuthApiMiddleware::class], function () {
    //User routes
    SimpleRouter::group(['prefix' => '/users'], function() {
      SimpleRouter::get('', [UserApiController::class, 'searchAllUsers']);
      SimpleRouter::get('/search/{accNumber}', [UserApiController::class, 'searchUserByAccNumber']);
    });

    SimpleRouter::group(['prefix' => '/transactions'], function () {
      SimpleRouter::post('/deposit', [TransactionApiController::class, 'deposit']);
      SimpleRouter::post('/withdraw', [TransactionApiController::class, 'withdraw']);
      SimpleRouter::post('/transfer', [TransactionApiController::class, 'transfer']);
    });
  });
});
