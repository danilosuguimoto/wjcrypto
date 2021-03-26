<?php

declare(strict_types=1);

namespace WjCrypto\Models;

use WjCrypto\Models\CoreModel;
use WjCrypto\DatabaseConnection\DBConnection as DB;

class UserModel extends CoreModel{
  
  public $table;
  public $columns;
  public $conn;
  
  public function __contruct($connection) {
    $this->conn = $connection;
  }

  public function getTableName()
  {
    return $this->table;
  }

  public function getColumn($clmn)
  {
    return $this->columns;
  }

  public function getAllColumns($clmns)
  {
    
  }
}
