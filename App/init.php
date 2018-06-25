<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use \Core\Router;
use \Core\Auth;

// ENV
$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

// Errors
if(filter_var(getenv('SHOW_ERROR'), FILTER_VALIDATE_BOOLEAN)) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

// Routing
$router = new AltoRouter();
require_once(__DIR__ . './routes.php');
$routeDispatcher = new Router($router);
