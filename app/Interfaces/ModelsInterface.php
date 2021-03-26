<?php

namespace WjCrypto\Interfaces;

interface ModelsInterface {
  public function setAttributes(string $tableName, array $columns);

  public function getDataFrom(string $columnName);
  
  public function getAllData();

  public function insertData(array $columns, array $values);

  public function deleteData(string $columns, string $value);
}
