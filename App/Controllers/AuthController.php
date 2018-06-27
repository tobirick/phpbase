<?php

namespace App\Controllers;

use \Core\BaseController;
use \App\Models\User;
use \Core\Token;
use \Core\Email;

class AuthController extends BaseController {
    public function puttest() {
        ddt('comes from put');
    }

    public function loginIndex() {
        $this->view('auth.login')->render();
    }

    public function login() {
        if(isset($_POST)) {
            $errors = $this->validate($_POST['user'], [
                'email' => 'required',
                'password' => 'required|minlength:6'
            ]);

            if($errors) {
                $this->redirectToRoute('login.index');
            } else {
                $user = new User([
                    'email' => $_POST['user']['email']
                ]);
                $success = $user->login($_POST['user']['password']);
                if($success === true) {
                    $this->redirectToRoute('index');
                } else {
                    $this->flash()->message($this->translate('Wrong credentials!'))->error()->set();
                    $this->redirectToRoute('login.index');
                }
            }
        }
    }

    public function logout() {
        User::logout();
        $this->redirectToRoute('index');
    }

    public function registerIndex() {
        $this->view('auth.register')->render();
    }

    public function register() {
        if(isset($_POST)) {
            $errors = $this->validate($_POST['user'], [
                'email' => 'required',
                'password' => 'required|minlength:6'
            ]);

            if($errors) {
                $this->redirectToRoute('register.index');
            } else {
                $user = new User([
                    'email' => $_POST['user']['email']
                ]);
                $success = $user->register($_POST['user']['password']);
                if($success === true) {
                    $this->redirectToRoute('login.index');
                } else {
                    $this->flash()->message($this->translate('Something went wrong!'))->error()->set();
                    $this->redirectToRoute('register.index');
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
            $this->redirectToRoute('login.index');
        }
    }

    public function passwordForgot() {
        if(isset($_POST)) {
            $errors = $this->validate($_POST['user'], [
                'email' => 'required'
            ]);

            if($errors) {
                $this->redirectToRoute('password.forgot.index');
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
                    $email->setHTML();
                    $email->from('password@phpbase.local')->to($_POST['user']['email'])->subject('Password Reset Link')->body($emailHTML);
                    //$email->send();

                    $this->flash()->message($this->translate('Check your E-Mails. We send you a Password Reset Link!'))->success()->set();
                    $this->redirectToRoute('login.index');
                } else {
                    $this->flash()->message($this->translate('User with provided E-Mail does not exist!'))->error()->set();
                    $this->redirectToRoute('password.forgot.index');
                }
            }
        }
    }

    public function passwordReset() {
       if(isset($_POST)) {
            $errors = $this->validate($_POST['user'], [
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
                    $this->flash()->message($this->translate('Password successfully changed. You can now login with your new password!'))->success()->set();
                    $this->redirectToRoute('login.index');
                } else {
                    $this->flash()->message($this->translate('Something went wrong!'))->error()->set();
                    $this->view('auth.password.reset', [
                        '_password_reset_token' => $_POST['_password_reset_token']
                    ])->render();
                }
            }
       }
    }
}