<?php

namespace Core;

class Flash {
    private static $flash;
    
    public static function message($message) {
        self::$flash['message'] = $message;

        return new static();
    }

    public static function error() {
        self::$flash['type'] = 'error';

        return new static();
    }

    public static function success() {
        self::$flash['type'] = 'success';

        return new static();
    }

    public static function set() {
        $_SESSION['flash'] = self::$flash;
    }

    public static function remove() {
        $_SESSION['flash'] = '';
    }
}