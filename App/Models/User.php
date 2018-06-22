<?php

namespace App\Models;

use \Core\Model;

class User extends Model {
    
    protected static $table = 'users';
    protected static $fillable = ['first_name', 'last_name'];

    public function test() {
        $users = self::query()->insert([
            'first_name' => 'Tobi',
            'last_name' => 'Rick'
        ]);
        
        return $users;
    }
}