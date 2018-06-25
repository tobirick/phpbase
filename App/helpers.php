<?php

function route($routeName, $routeParams = []) {
    return Core\Router::route($routeName, $routeParams);
}