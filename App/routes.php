<?php

use \Core\Middleware;

// Auth Routes
$router->get('/login', Middleware::guestRoute('AuthController@loginIndex'), 'login.index');
$router->post('/login', Middleware::guestRoute('AuthController@login'), 'login');
$router->get('/logout', Middleware::userRoute('AuthController@logout'), 'logout');
$router->get('/register', Middleware::guestRoute('AuthController@registerIndex'), 'register.index');
$router->post('/register', Middleware::guestRoute('AuthController@register'), 'register');

$router->get('/password/forgot', Middleware::guestRoute('AuthController@passwordForgotIndex'), 'password.forgot.index');
$router->post('/password/forgot', Middleware::guestRoute('AuthController@passwordForgot'), 'password.forgot');

$router->get('/password/reset/[a:token]', Middleware::guestRoute('AuthController@passwordResetIndex'), 'password.reset.index');
$router->post('/password/reset', Middleware::guestRoute('AuthController@passwordReset'), 'password.reset');

// Your routes
$router->get('/', Middleware::userRoute('IndexController@index'), 'index');
