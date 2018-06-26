<?php

namespace App\Controllers;

use \Core\BaseController;
use \App\Models\User;
use \Core\Token;
use \Core\Email;

class AuthController extends BaseController {
    public function loginIndex() {
        $this->view('auth.login')->render();
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
        $this->view('auth.register')->render();
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

    public function passwordForgotIndex() {
        $this->view('auth.password.forgot')->render();
    }

    public function passwordResetIndex($params) {
        $passwordResetToken = $params['token'];

        $currentTime = time();
        
        $user = User::query()->where([
            'password_reset_token' => $passwordResetToken
        ])->where('password_reset_expiry_date > ' . $currentTime)->get();

        if($user) {
            $this->view('auth.password.reset', [
                '_password_reset_token' => $passwordResetToken
            ])->render();
        } else {
            self::redirectToRoute('login.index');
        }
    }

    public function passwordForgot() {
        if(isset($_POST)) {
            $errors = self::validate($_POST['user'], [
                'email' => 'required'
            ]);

            if($errors) {
                self::redirectToRoute('password.forgot.index');
            } else {
                $user = new User([
                    'email' => $_POST['user']['email']
                ]);
                if($user->checkIfUserExists()) {
                    $token = new Token();
                    $tokenHash = $token->getHash();
                    $user->query()->where('email', $_POST['user']['email'])->update([
                        'password_reset_token' => $tokenHash,
                        'password_reset_expiry_date' => time() + (1 * 24 * 60 * 60)
                    ]);

                    // Send E-Mail
                    $emailHTML = $this->view('emails.passwordforgot', [
                        'password_reset_token' => $tokenHash
                    ])->getTemplate();

                    $email = new EMail();

                    self::redirectToRoute('login.index');
                } else {
                    self::redirectToRoute('password.forgot.index');
                }
            }
        }
    }

    public function passwordReset() {
       if(isset($_POST)) {
            $errors = self::validate($_POST['user'], [
                'password' => 'required|minlength:6'
            ]);
            
            if($errors) {
                $this->view('auth.password.reset', [
                    '_password_reset_token' => $_POST['_password_reset_token']
                ])->render();
            } else {
                $passwordHash = password_hash($_POST['user']['password'], PASSWORD_BCRYPT);

                $currentTime = time();

                $user = User::query()->where('password_reset_token', $_POST['_password_reset_token'])->where('password_reset_expiry_date > ' . $currentTime)->update([
                    'password_reset_token' => NULL,
                    'password_reset_expiry_date' => NULL,
                    'password' => $passwordHash
                ]);
                
                if($user) {
                    self::redirectToRoute('login.index');
                } else {
                    $this->view('auth.password.reset', [
                        '_password_reset_token' => $_POST['_password_reset_token']
                    ])->render();
                }
            }
       }
    }
}