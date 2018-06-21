<?php
namespace App\Controllers;

use \Core\BaseController;
use \Core\Ajax;
use \Core\Flash;
use \Core\Email;
use \App\Models\TestModel;

class IndexController extends BaseController {  
    public function index($params) {
        Flash::message('Some useful Flash Message you can add.')->success()->set();

        //$email = new Email();
        //$email->from('')->to('')->setHTML()->subject('This is subject')->body('This is body');
        //$email->send();
        TestModel::test();

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