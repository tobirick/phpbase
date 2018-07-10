<?php
namespace Core;

class BaseController {
    private $template;
    private $args;
    private $shares;

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
        
        $view = new View($this->template, $this->args);
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

    public function redirectBack() {
        $url = $_SERVER['HTTP_REFERER'];

        $this->redirect($url);
    }

    public function translate($key) {
        return Router::$lang->getTranslation($key);
    }
}