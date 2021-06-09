<?php

declare(strict_types=1);

use Pecee\SimpleRouter\SimpleRouter;

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . '/../lib/Helper.php';
require_once __DIR__ . "/../lib/Routes/RoutesApi.php";
require_once __DIR__ . "/../lib/Routes/Routes.php";

// error_reporting(E_ALL);
// ini_set('display_errors', '0');

session_start();

SimpleRouter::start();
