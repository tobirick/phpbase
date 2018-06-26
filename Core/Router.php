<?php
namespace Core;

class Router {
    private $namespace = 'App\Controllers\\';
    private $controller;
    private $method;
    private $params;
    private $match;
    private $langString = '/[en|de:lang]?';
    public static $lang;

    private static $router;

    public function __construct($router) {
        self::$router = $router;
        self::$lang = new Lang(isset($_SESSION['lang']) && $_SESSION['lang'] !== '' ? $_SESSION['lang'] : 'en');
    }

    public function get($route, $ctrl, $name = null) {
        self::$router->map('GET', $this->langString . $route, $ctrl, $name);
    }

    public function post($route, $ctrl, $name = null) {
        self::$router->map('POST', $this->langString . $route, $ctrl, $name);
    }

    public function put($route, $ctrl, $name = null) {
        self::$router->map('PUT', $this->langString . $route, $ctrl, $name);
    }

    public function patch($route, $ctrl, $name = null) {
        self::$router->map('PATCH', $this->langString . $route, $ctrl, $name);
    }

    public function delete($route, $ctrl, $name = null) {
        self::$router->map('DELETE', $this->langString . $route, $ctrl, $name);
    }

    public function matchRoute() {
        $this->match = self::$router->match();
        if($this->match) {
            $this->params = $this->match['params'];

            if(isset($this->params['lang'])) {
                self::$lang->setLanguage($this->match['params']['lang']);
            } else if(isset($_SESSION['lang'])) {
                self::$lang->setLanguage($_SESSION['lang']);
            }

            $lang = self::$lang->getCurrentLanguage();
            $_SESSION['lang'] = $lang;

            if(is_string($this->match['target'])) {
                $details = explode("@", $this->match['target']);
                $this->controller = $this->namespace . $details[0];
                $this->method = $details[1];
    
                $ctrl = new $this->controller;
                call_user_func([$ctrl, $this->method], $this->params);

                return;
            } else if (is_callable($this->match['target'])) {
                $this->method = $this->match['target'];

                call_user_func($this->method, $this->params);
                
                return;
            }
        }

        $ctrl = new BaseController();
        $ctrl->view('404')->render();;
    }

    public function route($routeName, $routeParams = []) {
        return self::$router->generate($routeName, $routeParams);
    }
}