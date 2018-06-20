<?php
namespace App\Controllers;

use \Core\BaseController;
use \Core\Ajax;
use \Core\Flash;

class IndexController extends BaseController {  
    public function index($params) {
        Flash::message('Some useful Flash Message you can add.')->success()->set();

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