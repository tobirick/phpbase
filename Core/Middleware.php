<?php

namespace Core;

class Middleware {
    public static function userRoute($ctrl) {
        if(isset($_SESSION['userid'])) {
            return $ctrl;
        }
        return 'AuthController@loginIndex';
    }

    public static function guestRoute($ctrl) {
        if(isset($_SESSION['userid'])) {
            return 'IndexController@index';
        }
        return $ctrl;
    }
}