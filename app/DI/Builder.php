<?php

namespace WjCrypto\DI;

use PDO;
use DI\Container;
use DI\ContainerBuilder;
use function DI\factory;
use Jenssegers\Blade\Blade;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use WjCrypto\DatabaseConnection\DBManager;
use WjCrypto\Models\ModelManager;
use WjCrypto\Models\TransactionModel;
use WjCrypto\Models\UserAddressModel;
use WjCrypto\Models\UserModel;
use WjCrypto\Views\ViewManager;

class Builder 
{
  private static $builder;
  
  /**
   * buildContainer
   *
   * Returns a new Container Object
   * 
   * @return Container
   */
  public static function buildContainer(): Container 
  {
    self::$builder = new ContainerBuilder();

    self::$builder->addDefinitions([
      'ModelManager' => factory(function (ContainerInterface $c) {
        return new ModelManager($c->get('DBManager'));
      }),

      'DBManager' => factory(function (ContainerInterface $c) {
        return new DBManager($c->get('PDO'));
      }),

      'PDO' => factory(function () {
        return new PDO("mysql:host=db; port=3306; dbname=wj_crypto;", "root", "t8n58jpOy-1Bg2PCkP17gflhGie1oRCV");
      }),

      'ViewManager' => factory(function (ContainerInterface $c) {
        return new ViewManager($c->get('Blade'));
      }),

      'Blade' => factory(function () {
        return new Blade(__DIR__ . '/../Views' , __DIR__ . '/../Views/cache');
      }),

      'UserModel' => factory(function () {
        return new UserModel();
      }),

      'UserAddressModel' => factory(function () {
        return new UserAddressModel();
      }),

      'TransactionModel' => factory(function () {
        return new TransactionModel();
      }),

      'Logger' => factory(function () {
        return new Logger('WjCrypto');
      })
    ]);

    return self::$builder->build();
  }
}
