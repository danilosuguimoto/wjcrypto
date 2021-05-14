<?php

declare(strict_types=1);

use Jenssegers\Blade\Blade;
use WjCrypto\Views\ViewManager;

/**
 * Creating a general purpose instance of the class in charge of 
 * rendering the application's views
 */
$view = new ViewManager(
  new Blade(__DIR__ . '/../Views/pages' , __DIR__ . '/../Views/cache')
);
