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

        $users = self::DB()->table('users')->select('id, first_name, last_name')->where('id', 1)->get();
        */

        /*
        $user = self::DB()->table('users')->insert([
            'first_name' => 'Tobi',
            'last_name' => 'Rick'
        ]);
        */

        //$user = self::DB()->table('users')->where('id', 14)->delete();

        /*
        self::DB()->table('users')->where([
            'first_name' => 'Tobi'
        ])->update([
            'first_name' => 'Updated First Name'
        ]);

        */

        $users = self::DB()->table('users')->select('id, first_name, last_name')->where('id', 9)->get();

        var_dump($users);
    }
}