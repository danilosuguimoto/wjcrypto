<?php

declare(strict_types=1);

use Pecee\SimpleRouter\SimpleRouter;
use WjCrypto\Controllers\Frontend\UserController;

//Frontend Routes
SimpleRouter::group(['namespace' => 'WjCrypto\Controllers\Frontend'], function() {
  SimpleRouter::get('/', [UserController::class, 'showHomePage']);
  SimpleRouter::get('/logout', [UserController::class, 'logout']);
  SimpleRouter::get('/createAccount', [UserController::class, 'showCreateAccPage']);
  SimpleRouter::post('/loginPost', [UserController::class, 'login']);
  SimpleRouter::post('/createPost', [UserController::class, 'create']);

  //Need Authentication
  SimpleRouter::group(['middleware' => WjCrypto\Middlewares\AuthMiddleware::class], function () {
    SimpleRouter::get('/deposit', [TransactionController::class, 'showDepositPage']);
    SimpleRouter::post('/depositPost', [TransactionController::class, 'deposit']);
    SimpleRouter::get('/withdraw', [TransactionController::class, 'showWithdrawPage']);
    SimpleRouter::post('/withdrawPost', [TransactionController::class, 'withdraw']);
    SimpleRouter::get('/transfer', [TransactionController::class, 'showTransferPage']);
    SimpleRouter::post('/transferPost', [TransactionController::class, 'transfer']);
    SimpleRouter::get('/balance', [TransactionController::class, 'showBalancePage']);
  });
});

