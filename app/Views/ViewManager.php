<?php

declare(strict_types=1);

namespace WjCrypto\Views;

use Jenssegers\Blade\Blade;

/**
 * ViewManager
 */
class ViewManager 
{
  protected static $blade;
    
  /**
   * __construct
   *
   * @return void
   */
  public function __construct(Blade $blade) 
  {
    self::$blade = $blade;
  }
  
  /**
   * getViewObject
   *
   * Will return an object of Blade
   * 
   * @return Blade
   */
  public static function getViewObject() 
  {
    return self::$blade;
  }
}