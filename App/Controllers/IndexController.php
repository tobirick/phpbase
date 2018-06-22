<?php
namespace App\Controllers;

use \Core\BaseController;
use \Core\Ajax;
use \Core\Flash;
use \Core\Email;
use \App\Models\User;

class IndexController extends BaseController {  
    public function create() {
        $ajaxData = Ajax::getJSON();

        $user = new User($ajaxData);

        $data = [];

        $createdUser = $user->query()->insertAndGet();

        if($createdUser) {
            $data['message'] = 'Successfully created!';
            $data['user'] = $createdUser;
        } else {
            $data['message'] = 'There was a error!';
        }

        Ajax::send($data)->json();
    }

    public function index($params) {
        Flash::message('Some useful Flash Message you can add.')->success()->set();

        //$email = new Email();
        //$email->from('')->to('')->setHTML()->subject('This is subject')->body('This is body');
        //$email->send();
        
        $user = new User([
            'first_name' => 'Testuser',
            'last_name' => 'Testuser2'
        ]);

        $user->query()->insert();

        //$users = User::query()->select()->get();

        /*
        $users = User::query()->insert([
            'first_name' => 'Tobi',
            'last_name' => 'Rick'
        ]);
        */

        //var_dump($users);

        self::view('index', [
            'testVar' => 'testVar Content',
            'id' => $params['id']
        ])->render();
    }

    public function ajax() {
        $ajaxData = Ajax::getJSON();

        $data['datatest'] = 'test';

        Ajax::send($data)->json();
    }
}