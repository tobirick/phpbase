<?php

use \Core\Middleware;
use \Core\BaseController;

$router->map('GET', '/login', Middleware::guestRoute('AuthController@loginIndex'), 'login.index');
$router->map('POST', '/login', Middleware::guestRoute('AuthController@login'), 'login');
$router->map('GET', '/logout', Middleware::userRoute('AuthController@logout'), 'logout');
$router->map('GET', '/register', Middleware::guestRoute('AuthController@registerIndex'), 'register.index');
$router->map('POST', '/register', Middleware::guestRoute('AuthController@register'), 'register');

$router->map('GET', '/password/forgot', Middleware::guestRoute('AuthController@passwordForgotIndex'), 'password.forgot.index');
$router->map('POST', '/password/forgot', Middleware::guestRoute('AuthController@passwordForgot'), 'password.forgot');

$router->map('GET', '/password/reset/[a:token]', Middleware::guestRoute('AuthController@passwordResetIndex'), 'password.reset.index');
$router->map('POST', '/password/reset', Middleware::guestRoute('AuthController@passwordReset'), 'password.reset');

$router->map('GET', '/[i:id]', Middleware::userRoute('IndexController@test'), 'testroute');
$router->map('GET', '/', Middleware::userRoute('IndexController@index'), 'index');

$router->map('GET', '/create', Middleware::userRoute('IndexController@create'));

$router->map('GET', '/test/[i:id]/[a:text]', function($params) {
    BaseController::view('test', $params)->render();
});