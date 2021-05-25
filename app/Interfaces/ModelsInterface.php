<?php

namespace WjCrypto\Interfaces;

interface ModelsInterface {  
  public function setAttributes(string $tableName, array $columns);

  public function selectDataFrom(string $column, $value);
  
  public function selectAllData();

  public function insertData(array $data);

  public function updateData(array $data, string $where, int $id);

  public function deleteData(string $columns, string $value);
}
