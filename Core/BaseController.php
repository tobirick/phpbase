<?php
namespace Core;

class BaseController {
    private $template;
    private $args;
    private $shares;

    private $sessionClass;
    private $flashClass;
    private $ajaxClass;
    private $validateClass;

    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CSRF::checkToken();
        }
    }

    public function view($template, $args = []) {
        $this->template = $template;
        $this->args = $args;

        return $this;
    }

    public function getTemplate() {
        $view = new View($this->template, $this->args, '');
        return $view->get();
    }

    public function render() {
        if(!isset($_SESSION['csrf_token'])) {
            CSRF::generateToken();
        }
        Shares::add('csrf_token', $_SESSION['csrf_token']);
        if(isset($_SESSION['flash'])) {
            Shares::add('flash', $_SESSION['flash']);
            Flash::remove();
        }
        if(isset($_SESSION['errors'])) {
            Shares::add('errors', $_SESSION['errors']);
            unset($_SESSION['errors']);
        }

        Shares::add('Lang', Router::$lang);

        Shares::add('Auth', new Auth);

        // Add your shares (Available in every View)
        Shares::add('share1', 'Share Test 1');
        Shares::add('share2', 'Share Test 2');
        $this->shares = Shares::get();
        
        $view = new View($this->template, $this->args, $this->shares);
        $view->render();
    }

    public function redirect($url) {
        $redirectTo = $url;
        header('Location: ' . $redirectTo  );
    }

    public function redirectToRoute($routeName, $routeParams = []) {
        $url = Router::route($routeName, $routeParams);
        
        $this->redirect($url);
    }

    public function translate($key) {
        return Router::$lang->getTranslation($key);
    }

    public function session() {
        if(!$this->sessionClass) {
            $this->sessionClass = new Session();
        }
        return $this->sessionClass;
    }

    public function flash() {
        if(!$this->flashClass) {
            $this->flashClass = new Flash();
        }
        return $this->flashClass;
    }

    public function ajax() {
        if(!$this->ajaxClass) {
            $this->ajaxClass = new Ajax();
        }
        return $this->ajaxClass;
    }

    public function validate($providedValues, $providedValidations) {
        if(!$this->validateClass) {
            $this->validateClass = new Validator($providedValues, $providedValidations, Router::$lang);
        }
        
        $errors = $this->validateClass->validate();

        if($errors) {
            $_SESSION['errors'] = $errors;
        }

        return $errors;
    }
}