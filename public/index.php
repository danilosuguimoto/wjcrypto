<?php

declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../lib/Routes.php";
require_once __DIR__ . '/../lib/Helper.php';

use Pecee\SimpleRouter\SimpleRouter;

// error_reporting(E_ALL);
// ini_set('display_errors', '0');

SimpleRouter::start();
