<?php
namespace App\Controllers;

use \Core\BaseController;
use \Core\Email;
use \App\Models\User;

class IndexController extends BaseController {
    public function index() {
        self::redirectToRoute('testroute', ['id' => 123]);
    }  

    public function create() {
        $ajaxData = self::ajax()->getJSON();

        $user = new User($ajaxData);

        $data = [];

        $createdUser = $user->query()->insertAndGet();

        if($createdUser) {
            $data['message'] = 'Successfully created!';
            $data['user'] = $createdUser;
        } else {
            $data['message'] = 'There was a error!';
        }

        self::ajax()->send($data)->json();
    }

    public function test($params) {
        self::flash()->message('Some useful Flash Message you can add.')->success()->set();

        //$email = new Email();
        //$email->from('')->to('')->setHTML()->subject('This is subject')->body('This is body');
        //$email->send();
        
        /*
        $user = new User([
            'first_name' => 'Testuser',
            'last_name' => 'Testuser2'
        ]);

        $user->query()->insert();
        */

        $users = User::query()->get();

        /*
        $users = User::query()->insert([
            'first_name' => 'Tobi',
            'last_name' => 'Rick'
        ]);
        */

        //var_dump($users);

        $data = [
            'first_name' => '',
            'last_name' => 'dasdasdasdasda'
        ];

        
        $validator = self::validate($data, [
            'first_name' => 'required|minlength:100',
            'last_name' => 'required|maxlength:5'
        ]);
        

        self::view('index', [
            'testVar' => 'testVar Content',
            'id' => $params['id']
        ])->render();
    }
}