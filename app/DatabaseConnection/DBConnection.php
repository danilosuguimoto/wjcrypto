<?php

declare(strict_types=1);

namespace WjCrypto\DatabaseConnection;

use PDO;

class DBConnection {

  protected static $connection;

  public function __construct()
  {
    $connection = new PDO("mysql:host=localhost; port=3306; dbname=wj_crypto;", "root", "t8n58jpOy-1Bg2PCkP17gflhGie1oRCV");
    self::$connection = $connection;
  }

  public function getDBConnection() {
    return self::$connection;
  }

}
