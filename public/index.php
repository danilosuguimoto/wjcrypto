<?php

require "../vendor/autoload.php";

use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/', function() {
  echo "test";
});

SimpleRouter::start();
