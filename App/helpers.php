<?php

function ddt($data) {
    var_export($data);
    die();
}

function route($routeName, $routeParams = []) {
    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

    return $url . Core\Router::route($routeName, $routeParams);
}

function csrf() {
    echo '<input type="hidden" name="_csrftoken" value="' . $_SESSION['csrf_token'] . '">';
}

function csrf_token() {
    return $_SESSION['csrf_token'];
}

function method($method) {
    echo '<input type="hidden" name="_method" value="' . $method . '">';
}

function asset($link) {
    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

    echo $url . '/' . $link;
}