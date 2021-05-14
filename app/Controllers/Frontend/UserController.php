<?php

declare(strict_types=1);

namespace WjCrypto\Controllers\Frontend;

use Helper;
use WjCrypto\Models\UserModel;
use WjCrypto\Views\ViewManager;

class UserController {
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
    $this->blade = ViewManager::getViewObject();
  }

  public function showHomePage() {
    echo $this->blade->render('general_layout', ['title' => 'Home']);
  }
}
