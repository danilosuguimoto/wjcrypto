<?php

namespace WjCrypto\Logs;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LogManager
{
  private static Logger $logger;

  public function __construct(Logger $logger)
  {
    self::$logger = $logger;
  }

  public function log()
  {
    self::$logger->pushHandler(new StreamHandler(__DIR__ . '/WjCrypto.log', Logger::ERROR));
  }
}
