<?php

use WjCrypto\DatabaseConnection\DBManager;

try {
  $connection = new DBManager(
    new PDO(
      "mysql:host=db; port=3306; dbname=wj_crypto;", 
      "root", 
      "t8n58jpOy-1Bg2PCkP17gflhGie1oRCV"
    )
  );  
} catch (PDOException $e) {
  echo $e->getMessage();
}
