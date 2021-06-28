<?php

declare(strict_types=1);

namespace WjCrypto\Models;

use Exception;
use PDO;
use WjCrypto\DI\Builder;
use WjCrypto\Interfaces\ModelsInterface;

class CoreModel extends ModelManager implements ModelsInterface
{
  private static $tableName;
  private static $columns;

  /**
   * bindStatementValue
   *
   * Returns an array of strings that binds SQL paramenters for safe statements execution
   * 
   * @param  array $data
   * @return array
   */
  private static function bindStatementValue(array $data)
  {
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
  public static function checkIfColumnExists(string $columnName) 
  {
    if(!in_array($columnName, self::$columns)) {
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
  public static function setAttributes(string $tableName, array $columns) 
  {
    self::$tableName = $tableName;
    self::$columns = $columns;
  }

  /**
   * getAttributes
   *
   * @return array
   */
  public static function getAttributes() 
  {
    return [
      'tableName' => self::$tableName,
      'columns' => self::$columns
    ];
  }

  /**
   * selectDataFrom
   *
   * Selects data from the specified table, based on the WHERE argument (ID)
   *
   * @param  int $id
   * @return array|object|false
   */
  public static function selectDataFrom(string $column, $value) 
  {
    Builder::buildContainer()->get('ModelManager');

    try {
      self::checkIfColumnExists($column);

      $stmt = self::$connection->getDBConnection()->prepare(
        "SELECT * FROM " . self::$tableName . " WHERE $column=:VAL"
      );
      $stmt->bindParam(":VAL", $value);
      $stmt->execute();

      $result = $stmt->fetchAll(PDO::FETCH_OBJ);

      return $result;
    }
    catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  /**
   * selectAllData
   *
   * Returns all data in the given table
   * 
   * @return array
   */
  public static function selectAllData() 
  {
    Builder::buildContainer()->get('ModelManager');

    try {
      $stmt = self::$connection->getDBConnection()->prepare(
        "SELECT * FROM " . self::$tableName
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
  public static function insertData(array $data) 
  {
    Builder::buildContainer()->get('ModelManager');

    $bindedValues = self::bindStatementValue($data);

    foreach($data as $column => $value) {
      $columns[] = $column; 
    }

    $bindedValuesStr = implode(", ", $bindedValues);
    $columnsStr = implode(", ", $columns);

    try {
      foreach($columns as $column) {
        self::checkIfColumnExists($column);
      }

      $stmt = self::$connection->getDBConnection()->prepare(
        "INSERT INTO " . self::$tableName . " ($columnsStr) VALUES ($bindedValuesStr)"
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
   * @param  string $whereColumn
   * @param  mixed $whereValue
   * @return void
   */
  public static function updateData(array $data, string $whereColumn, $whereValue) 
  {
    Builder::buildContainer()->get('ModelManager');

    $bindedValues = self::bindStatementValue($data);

    foreach($data as $column => $value) {
      $concatData[] = "$column=" . $bindedValues[$column];
    }

    if(count($concatData) > 1) {
      $concatDataStr = implode(", ", $concatData);
    } else {
      $concatDataStr = $concatData[0];
    }

    try {
      foreach($data as $column => $value) {
        self::checkIfColumnExists($column);
      }
      
      $stmt = self::$connection->getDBConnection()->prepare(
        "UPDATE " . self::$tableName . " SET $concatDataStr WHERE $whereColumn=:VAL"
      );

      foreach($bindedValues as $column => $bindedValue) {
        $stmt->bindParam($bindedValue, $data[$column]);
      }

      $stmt->bindParam(":VAL", $whereValue);
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
  public static function deleteData(string $column, string $value) 
  {
    Builder::buildContainer()->get('ModelManager');

    try {
      self::checkIfColumnExists($column);

      $stmt = self::$connection->getDBConnection()->prepare(
        "DELETE FROM " . self::$tableName . " WHERE $column=:VAL"
      );
      $stmt->bindParam(":VAL", $value);
      $stmt->execute();
    } 
    catch(Exception $e) {
      echo $e->getMessage(); 
    }
  }
}
