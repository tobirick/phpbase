<?php

namespace Core;

class Session {

    public function get($key) {
        return $_SESSION[$key];
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function remove($key) {
        unset($_SESSION[$key]);
    }
}