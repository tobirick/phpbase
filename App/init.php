<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use \Core\Router;
use \Core\Auth;

// ENV
$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

// Routing
$router = new AltoRouter();
require_once(__DIR__ . './routes.php');
$routeDispatcher = new Router($router);