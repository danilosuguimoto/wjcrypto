<?php

namespace WjCrypto\Models;

use WjCrypto\DatabaseConnection\DBManager;
use WjCrypto\Interfaces\DBInterface;

class ModelManager
{
  protected static DBManager $connection;

  public function __construct(DBInterface $connection) 
  {
    self::$connection = $connection;
  }
}
