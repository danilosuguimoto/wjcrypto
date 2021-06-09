<?php

namespace WjCrypto\Interfaces;

interface DBInterface
{
  public static function getDBConnection(): object;
}
