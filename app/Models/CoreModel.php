<?php

declare(strict_types=1);

namespace WjCrypto\Models;

use Exception;
use PDO;
use WjCrypto\DatabaseConnection\DBManager as Database;
use WjCrypto\Interfaces\ModelsInterface;

/**
 * CoreModel
 */
class CoreModel implements ModelsInterface {
  private $tableName;
  private $columns;
  private $connection;
  
  /**
   * __construct
   * 
   * Sets the database connection
   *
   * @return void
   */
  public function __construct() {
    $this->connection = Database::getDBConnection();
  }
  
  /**
   * bindStatementValue
   *
   * This method will return an array of strings for binding
   * SQL paramenters, so that each statement can be safeley executed
   * 
   * @param  array $data
   * @return array
   */
  private function bindStatementValue(array $data)  {
    foreach($data as $column => $value) {
      $bindedValues[$column] = ":" . strtoupper($column);
    }

    return $bindedValues;
  }
  
  /**
   * checkIfColumnExists
   *
   * This method compares the $columns attribute with the column currently in use
   * by any of the CRUD methods
   * 
   * @param  string $columnName
   * @return void
   */
  public function checkIfColumnExists(string $columnName) {
    if(!in_array($columnName, $this->columns)) {
      throw new Exception("Coluna $columnName não encontrada.");
    }
  }
  
  /**
   * setAttributes
   *
   * @param  string $tableName
   * @param  array $columns
   * @return void
   */
  public function setAttributes(string $tableName, array $columns) {
    $this->tableName = $tableName;
    $this->columns = $columns;
  }
  
  /**
   * getAttributes
   *
   * @return array
   */
  public function getAttributes() {
    return [
      'tableName' => $this->tableName,
      'columns' => $this->columns
    ];
  }
  
  /**
   * selectDataFrom
   *
   * Selects data from the specified table, based on the WHERE argument (ID)
   *
   * @param  int $id
   * @return object
   */
  public function selectDataFrom(string $column, $value) {
    try {
      $this->checkIfColumnExists($column);

      $stmt = $this->connection->prepare(
        "SELECT * FROM $this->tableName WHERE $column=:VAL"
      );
      $stmt->bindParam(":VAL", $value);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_OBJ);

      return $result;
    }
    catch(Exception $e) {
      echo $e->getMessage();
    }
  }
  
  /**
   * selectAllData
   *
   * @return array
   */
  public function selectAllData() {
    try {
      $stmt = $this->connection->prepare(
        "SELECT * FROM $this->tableName"
      );
      $stmt->execute();
  
      $result = $stmt->fetchAll(PDO::FETCH_OBJ);
  
      return $result;
    }
    catch(Exception $e) {
      echo $e->getMessage();
    }
  }
  
  /**
   * insertData
   *
   * @param  array $data
   * @return void
   */
  public function insertData(array $data) {
    $bindedValues = $this->bindStatementValue($data);

    foreach($data as $column => $value) {
      $columns[] = $column; 
    }

    $bindedValuesStr = implode(", ", $bindedValues);
    $columnsStr = implode(", ", $columns);

    try {
      foreach($columns as $column) {
        $this->checkIfColumnExists($column);
      }

      $stmt = $this->connection->prepare(
        "INSERT INTO  $this->tableName ($columnsStr) VALUES ($bindedValuesStr)"
      );

      foreach($bindedValues as $column => $value) {
        $stmt->bindParam($value, $data[$column]);
      }
      
      $stmt->execute();
    }
    catch(Exception $e) {
      echo $e->getMessage();
    }
  }
  
  /**
   * updateData
   *
   * @param  array $data
   * @param  string $where
   * @param  int $id
   * @return void
   */
  public function updateData(array $data, string $where, int $id) {
    $bindedValues = $this->bindStatementValue($data);

    foreach($data as $column => $value) {
      $concatData[] = "$column=" . $bindedValues[$column];
    }

    $concatDataStr = implode(", ", $concatData);

    try {
      foreach($data as $column => $value) {
        $this->checkIfColumnExists($column);
      }
      
      $stmt = $this->connection->prepare(
        "UPDATE $this->tableName SET $concatDataStr WHERE $where=:ID"
      );
  
      foreach($bindedValues as $bindedValue) {
        $stmt->bindParam($bindedValue, $value);
      }
  
      $stmt->bindParam(":ID", $id);
      $stmt->execute();    
    }
    catch(Exception $e) {
      echo $e->getMessage();
    }
  }
  
  /**
   * deleteData
   *
   * @param  string $column
   * @param  string $value
   * @return void
   */
  public function deleteData(string $column, string $value) {
    try {
      $this->checkIfColumnExists($column);

      $stmt = $this->connection->prepare(
        "DELETE FROM $this->tableName WHERE $column=:VAL"
      );
      $stmt->bindParam(":VAL", $value);
      $stmt->execute();
    } 
    catch(Exception $e) {
      echo $e->getMessage(); 
    }
  }
}
