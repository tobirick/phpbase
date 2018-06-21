<?php

use \Core\Middleware;
use \Core\BaseController;

$router->map('GET', '/[i:id]', Middleware::requireLogin('IndexController@index'));
$router->map('POST', '/', Middleware::requireLogin('IndexController@ajax'));

$router->map('GET', '/test/[i:id]/[a:text]', function($params) {
    BaseController::view('test', $params)->render();
});