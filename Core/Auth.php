<?php

namespace Core;

class Auth {
    public function check() {
        if(isset($_SESSION['userid'])) {
            return true;
        }

        return false;
    }
}