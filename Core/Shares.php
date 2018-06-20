<?php

namespace Core;

class Shares {
    private static $shares = [];

    public static function add($key, $value) {
        self::$shares[$key] = $value;
    }

    public static function get() {
        return self::$shares;
    }
}