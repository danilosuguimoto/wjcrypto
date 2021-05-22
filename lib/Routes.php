<?php

declare(strict_types=1);

use Pecee\SimpleRouter\SimpleRouter;
use WjCrypto\Controllers\API\UserApiController;
use WjCrypto\Controllers\Frontend\UserController;

//API Controllers
SimpleRouter::group(['namespace' => 'WjCrypto\Controllers\API'], function() {
  SimpleRouter::group(['prefix' => '/rest/API'], function() {
    //User routes
    SimpleRouter::group(['prefix' => '/users'], function() {
      SimpleRouter::get('', [UserApiController::class, 'getAllUsers']);
      SimpleRouter::get('/search/{id}', [UserApiController::class, 'getUserById']);
      
      SimpleRouter::post('/create', [UserApiController::class, 'createUser']);
    });
  });
});

//Frontend Controllers
SimpleRouter::group(['namespace' => 'WjCrypto\Controllers\Frontend'], function() {
  SimpleRouter::get('/', [UserController::class, 'showHomePage']);
  SimpleRouter::post('/login', [UserController::class, 'login']);
});
