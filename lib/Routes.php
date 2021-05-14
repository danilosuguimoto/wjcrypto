<?php

declare(strict_types=1);

use Pecee\SimpleRouter\SimpleRouter;
use WjCrypto\Controllers\API\UserApiController;
use WjCrypto\Controllers\Frontend\UserController;

//API Controllers
SimpleRouter::group(['namespace' => 'WjCrypto\Controllers\API'], function() {
  SimpleRouter::get('/users', [UserApiController::class, 'getAllUsers']);
  SimpleRouter::get('/users/{id}', [UserApiController::class, 'getUserById']);
  SimpleRouter::get('/users/create', [UserApiController::class, 'createUser']);
});

//Frontend Controllers
SimpleRouter::group(['namespace' => 'WjCrypto\Controllers\Frontend'], function() {
  SimpleRouter::get('/', [UserController::class, 'showHomePage']);
});
