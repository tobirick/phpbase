<?php

namespace Core;

class Flash {
    private $flash;
    
    public function message($message) {
        $this->flash['message'] = $message;

        return $this;
    }

    public function error() {
        $this->flash['type'] = 'error';

        return $this;
    }

    public function success() {
        $this->flash['type'] = 'success';

        return $this;
    }

    public function set() {
        $_SESSION['flash'] = $this->flash;
    }

    public function remove() {
        unset($_SESSION['flash']);
    }
}