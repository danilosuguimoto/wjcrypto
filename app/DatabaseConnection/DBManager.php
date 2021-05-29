<?php

declare(strict_types=1);

namespace WjCrypto\DatabaseConnection;

use PDO;
use WjCrypto\Interfaces\DBInterface;

/**
 * DBManager
 */
class DBManager implements DBInterface {

  private static $connection;
  
  /**
   * __construct
   *
   * @return void
   */
  public function __construct(PDO $connection) {
    self::$connection = $connection;
  }
  
  /**
   * getDBConnection
   *
   * @return PDO
   */
  public static function getDBConnection(): object {
    return self::$connection;
  }

}
