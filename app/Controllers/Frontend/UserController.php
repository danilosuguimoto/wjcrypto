<?php

declare(strict_types=1);

namespace WjCrypto\Controllers\Frontend;

use Helper;
use Jenssegers\Blade\Blade;
use WjCrypto\Models\UserModel;

class UserController
{
  private Blade $view;
  private UserModel $user;

  public function __construct() 
  {
    $this->view = Helper::getContainer('ViewManager')->getViewObject();
    $this->user = Helper::getContainer('UserModel');
  }

  /**
   * login
   *
   * Sends a POST request to authenticate the user based on the form data received
   * 
   * @return void
   */
  public function login() 
  {
    $data = [
      'acc_number' => filter_input(INPUT_POST, 'acc_number', FILTER_SANITIZE_STRING),
      'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)
    ];

    $result = Helper::getApiConnection('/authentication', $data);
    
    if($result->message == $this->user::USER_AUTHENTICATION_SUCCESS) {
      $_SESSION['acc_number'] = $data['acc_number'];
      $_SESSION['authentication_token'] = $result->authentication_token;
      
      Helper::response()->redirect('/');
    } else {
      $this->showHomePage(['message' => $result->message]);
    }
  }
  
  /**
   * logout
   * 
   * Destroys the user session and logs it out
   * 
   * @return void
   */
  public function logout()
  {
    session_unset();
    session_destroy();
    Helper::response()->redirect('/');
  }
  
  /**
   * create
   *
   * Sends a POST request to create a new user based on the form data received
   * 
   * @return void
   */
  public function create()
  {
    $data = [
      'user' => [
        'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
        'phone' => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING),
        'document_number' => filter_input(INPUT_POST, 'document_number', FILTER_SANITIZE_STRING),
        'dob' => filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING),
        'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)
      ],
      'address' => [
        'country' => filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING),
        'region' => filter_input(INPUT_POST, 'region', FILTER_SANITIZE_STRING),
        'postcode' => filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING),
        'city' => filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING),
        'street' => filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING),
      ]
    ];

    $result = Helper::getApiConnection('/users/create', $data);

    if(!empty($data) && Helper::request()->getMethod() == 'post'){
      unset($data);
    }

    $this->showCreateAccPage([
      'acc_number' => $result->acc_number,
      'message' => $result->message
    ]);
  }
  
  /**
   * showCreateAccPage
   *
   * Renders the Create Account page
   * 
   * @return void
   */
  public function showCreateAccPage(?array $params = null)
  {
    if(!empty($params)) {
      echo $this->view->render('pages/create_acc', $params);
    } else {
      echo $this->view->render('pages/create_acc');
    }
  }
  
  /**
   * showLoginPage
   *
   * Renders the Home page based on the user session
   * 
   * @return void
   */
  public function showHomePage(?array $params = null)
  {
    $session = Helper::hasSession();

    if($session) {
      echo $this->view->render('pages/home', ['balance' => Helper::getUserBalance()]);
    } elseif(!empty($params)) {
      echo $this->view->render('pages/login', $params);
    } else {
      echo $this->view->render('pages/login');
    }
  }
}
