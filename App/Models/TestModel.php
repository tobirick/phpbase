<?php

namespace App\Models;

use \Core\Model;

class TestModel extends Model {
    public function test() {
        
        /*
        $users = self::DB()->table('users')->select('id, first_name, last_name')->where([
            'id' => 1,
            'first_name' => 'Tobi'
        ])->get();
        */

        $user = self::DB()->table('users')->insert([
            'first_name' => 'Testname',
            'last_name' => 'Testlastname'
        ]);

        var_dump($user);
    }
}