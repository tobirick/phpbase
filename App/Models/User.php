<?php

namespace App\Models;

use \Core\Model;

class User extends Model {
    
    protected static $table = 'users';
    protected static $fillable = ['email', 'password'];

    public $email;

    private function checkIfUserExists() {
        $user = self::query()->select()->where('email', $this->email)->get();

        if($user) {
            return $user[0];
        } else {
            return false;
        }
    }

    private function comparePasswords($password, $password_hash) {
        if(password_verify($password, $password_hash)) {
            return true;
        }
        return false;
    }

    public function login($password) {
        $user = $this->checkIfUserExists();

        if($user) {
            if($this->comparePasswords($password, $user->password)) {
                unset($_SESSION['userid']);
                session_regenerate_id(true);
                if(!isset($_SESSION['userid'])) {
                    $_SESSION['userid'] = $user->id;
                    return true;
                }
            }
        }

        return 'Wrong Credentials';
    }

    public function register($password) {
        if($this->checkIfUserExists()) {
            return false;
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $user = self::query()->insert([
            'email' => $this->email,
            'password' => $passwordHash
        ]);

        if($user) {
            return true;
        } else {
            return 'User already exists';
        }
    }

    public function logout() {
        unset($_SESSION['userid']);
        
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
        
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        
        session_destroy();
    }
}