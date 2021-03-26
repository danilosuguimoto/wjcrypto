<?php

declare(strict_types=1);

namespace WjCrypto\Models;

use PDO;
use WjCrypto\DatabaseConnection\DBConnection as DB;
use WjCrypto\Interfaces\ModelsInterface;

class CoreModel implements ModelsInterface {
  private $tableName;
  private $columns;
  private static $conn;

  public function __construct(DB $connection) {
    self::$conn = $connection->getDBConnection();
  }

  public function setAttributes(string $tableName, array $columns) {
    $this->tableName = $tableName;
    $this->columns = $columns;
  }

  public function getTableName() {
    return $this->tableName;
  }

  public function getColumns() {
    return $this->columns;
  }

  public function getDataFrom(string $columnName) {
    $stmt = self::$conn->prepare("select " . $columnName . " from " . $this->tableName);
    
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $result;
  }

  public function getAllData() {
    $stmt = self::$conn->prepare("select * from " . $this->tableName);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $result;
  }

  public function insertData(array $columns, array $values) {
    $relateArrays = array_combine($columns, $values);



    $stmt = self::$conn->prepare("insert into " . $this->tableName . "()");
  }

  public function deleteData(string $column, string $value) {
    $stmt = self::$conn->prepare("delete from " . $this->tableName . " where " . $column . "=:VALUE");

    $stmt->bindParam(":VALUE", $value);
    
    $stmt->execute();
  }
}
