<?php

namespace Core;

class Middleware {
    public static function requireLogin($ctrl) {
        if(isset($_SESSION['userid'])) {
            return $ctrl;
        }
        return 'AuthController@loginIndex';
    }
}