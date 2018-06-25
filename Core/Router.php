<?php
namespace Core;

class Router {
    private $namespace = 'App\Controllers\\';
    private $controller;
    private $method;
    private $params;
    private $match;

    private static $router;

    public function __construct($router) {
        self::$router = $router;
        $this->match = self::$router->match();
    }

    public function matchRoute() {
        if($this->match) {
            $this->params = $this->match['params'];
            if(is_string($this->match['target'])) {
                $details = explode("@", $this->match['target']);
                $this->controller = $this->namespace . $details[0];
                $this->method = $details[1];
    
                call_user_func([$this->controller, $this->method], $this->params);

                return;
            } else if (is_callable($this->match['target'])) {
                $this->method = $this->match['target'];

                call_user_func($this->method, $this->params);
                
                return;
            }
        }

        BaseController::view('404')->render();;
    }

    public function route($routeName, $routeParams = []) {
        return self::$router->generate($routeName, $routeParams);
    }
}