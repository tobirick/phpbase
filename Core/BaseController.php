<?php
namespace Core;

class BaseController {
    private $template;
    private $args;
    private static $shares;

    private static $sessionClass;
    private static $flashClass;
    private static $ajaxClass;
    private static $validateClass;

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
        self::$shares = Shares::get();
        
        $view = new View($this->template, $this->args, self::$shares);
        $view->render();
    }

    public static function redirect($url) {
        $redirectTo = $url;
        header('Location: ' . $redirectTo  );
    }

    public static function redirectToRoute($routeName, $routeParams = []) {
        $url = Router::route($routeName, $routeParams);
        
        self::redirect($url);
    }

    public static function translate($key) {
        return Router::$lang->getTranslation($key);
    }

    public static function session() {
        if(!self::$sessionClass) {
            self::$sessionClass = new Session();
        }
        return self::$sessionClass;
    }

    public static function flash() {
        if(!self::$flashClass) {
            self::$flashClass = new Flash();
        }
        return self::$flashClass;
    }

    public static function ajax() {
        if(!self::$ajaxClass) {
            self::$ajaxClass = new Ajax();
        }
        return self::$ajaxClass;
    }

    public static function validate($providedValues, $providedValidations) {
        if(!self::$validateClass) {
            self::$validateClass = new Validator($providedValues, $providedValidations, Router::$lang);
        }
        
        $errors = self::$validateClass->validate();

        if($errors) {
            $_SESSION['errors'] = $errors;
        }

        return $errors;
    }
}