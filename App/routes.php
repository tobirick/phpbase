<?php

use \Core\Middleware;
use \Core\BaseController;

$router->map('GET', '/[i:id]', Middleware::requireLogin('IndexController@test'), 'testroute');
$router->map('GET', '/', Middleware::requireLogin('IndexController@index'), 'index');

$router->map('GET', '/create', Middleware::requireLogin('IndexController@create'));

$router->map('GET', '/test/[i:id]/[a:text]', function($params) {
    BaseController::view('test', $params)->render();
});