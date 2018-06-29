<?php
namespace App\Controllers;

use \Core\BaseController;
use \Core\Email;
use \App\Models\User;

class IndexController extends BaseController {
    public function index() {
        $this->view('index')->render();
    }
}