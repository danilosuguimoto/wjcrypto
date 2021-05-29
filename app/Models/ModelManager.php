<?php

namespace WjCrypto\Models;

use WjCrypto\Interfaces\DBInterface;

class ModelManager {
  protected static $connection;

  public function __construct(DBInterface $connection) {
    self::$connection = $connection;
  }
}
