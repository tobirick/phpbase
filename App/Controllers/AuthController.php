<?php

namespace App\Controllers;

use \Core\BaseController;
use \App\Models\User;

class AuthController extends BaseController {
    public function loginIndex() {
        self::view('auth.login')->render();
    }

    public function login() {
        if(isset($_POST)) {
            $errors = self::validate($_POST['user'], [
                'email' => 'required',
                'password' => 'required|minlength:6'
            ]);

            if($errors) {
                self::redirectToRoute('login.index');
            } else {
                $user = new User([
                    'email' => $_POST['user']['email']
                ]);
                $success = $user->login($_POST['user']['password']);
                if($success === true) {
                    self::redirectToRoute('index');
                } else {
                    self::redirectToRoute('login.index');
                }
            }
        }
    }

    public function logout() {
        User::logout();
        self::redirectToRoute('index');
    }

    public function registerIndex() {
        self::view('auth.register')->render();
    }

    public function register() {
        if(isset($_POST)) {
            $errors = self::validate($_POST['user'], [
                'email' => 'required',
                'password' => 'required|minlength:6'
            ]);

            if($errors) {
                self::redirectToRoute('register.index');
            } else {
                $user = new User([
                    'email' => $_POST['user']['email']
                ]);
                $success = $user->register($_POST['user']['password']);
                if($success === false) {
                    self::redirectToRoute('login.index');
                } else {
                    self::redirectToRoute('register.index');
                }
            }
        }
    }
}