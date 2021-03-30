<?php

declare(strict_types=1);

namespace WjCrypto\Models;

use PDO;
use WjCrypto\DatabaseConnection\DBConnection as DB;
use WjCrypto\Interfaces\ModelsInterface;

class CoreModel implements ModelsInterface {
  private $tableName;
  private $columns;
  private $conn;

  public function __construct(DB $connection) {
    $this->conn = $connection->getDBConnection();
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
    $stmt = $this->conn->prepare(
      "SELECT $columnName FROM $this->tableName"
    );
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $result;
  }

  public function getAllData() {
    $stmt = $this->conn->prepare(
      "SELECT * FROM $this->tableName"
    );
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $result;
  }

  public function insertData(array $columns, array $values) {
    $bindKeys = [];

    foreach($values as $value) {
      $bindKeys[$value] = ":" . strtoupper($value);
    }

    $bindKeysStr = implode(", ", $bindKeys);
    $columnsStr = implode(", ", $columns);

    $stmt = $this->conn->prepare(
      "INSERT INTO  $this->tableName ($columnsStr) VALUES ($bindKeysStr)"
    );

    foreach($bindKeys as $bindKey) {
      $stmt->bindParam($bindKey, $value);
    }

    $stmt->execute();
  }

  public function deleteData(string $column, string $value) {
    $stmt = $this->conn->prepare(
      "DELETE FROM $this->tableName WHERE $column=:VALUE"
    );
    $stmt->bindParam(":VALUE", $value);
    $stmt->execute();
  }
}
