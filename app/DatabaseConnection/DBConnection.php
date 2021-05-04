<?php

declare(strict_types=1);

namespace WjCrypto\DatabaseConnection;

use PDO;

/**
 * DBConnection
 */
class DBConnection {

  private static $connection;
  
  /**
   * __construct
   *
   * @return void
   */
  public function __construct() {
    $connection = new PDO("mysql:host=localhost; port=3306; dbname=wj_crypto;", "root", "t8n58jpOy-1Bg2PCkP17gflhGie1oRCV");
    self::$connection = $connection;
  }
  
  /**
   * getDBConnection
   *
   * @return PDO
   */
  public function getDBConnection() {
    return self::$connection;
  }

}
