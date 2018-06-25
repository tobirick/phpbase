<?php

function ddt($data) {
    var_export($data);
    die();
}

function route($routeName, $routeParams = []) {
    return Core\Router::route($routeName, $routeParams);
}

function csrf() {
    echo '<input type="hidden" name="_csrftoken" value="' . $_SESSION['csrf_token'] . '">';
}