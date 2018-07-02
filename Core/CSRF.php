<?php

namespace Core;

class CSRF {
    public static function generateToken() {
        $token = new Token();
        $value = $token->getValue();
        $_SESSION["csrf_token"] = $value;
    }

    public static function getToken() {
        if(isset($_SESSION['csrf_token'])) {
            return $_SESSION["csrf_token"];
        } else {
            return false;
        }
    }

    public static function checkToken() {
        if (!isset($_POST['_csrftoken']) && !isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
            header('HTTP/1.0 403 Forbidden');
            exit('Missing CSRF token');
        }

        // Get the token from the session
        $token = $_SESSION['csrf_token'];

        $usertoken = isset($_POST['_csrftoken']) ? $_POST['_csrftoken'] : (isset($_SERVER['HTTP_X_CSRF_TOKEN']) ? $_SERVER['HTTP_X_CSRF_TOKEN'] : '');
 
        if ($usertoken != $token) {
            header('HTTP/1.0 403 Forbidden');
            exit('Invalid CSRF token');
        }  
    }
}