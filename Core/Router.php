<?php
namespace Core;

class Router {
    private $namespace = 'App\Controllers\\';
    private $router;
    private $controller;
    private $method;
    private $params;
    private $match;

    public function __construct($router) {
        $this->router = $router;
        $this->match = $this->router->match();

        $this->matchRoute();
    }

    public function matchRoute() {
        if($this->match) {
            $this->params = $this->match['params'];
            if(is_string($this->match['target'])) {
                $details = explode("@", $this->match['target']);
                $this->controller = $this->namespace . $details[0];
                $this->method = $details[1];

                $ctrl = new $this->controller;
                $ctrl::$router = $this;
    
                call_user_func([$ctrl, $this->method], $this->params);

                return;
            } else if (is_callable($this->match['target'])) {
                $this->method = $this->match['target'];

                call_user_func($ctrl, $this->params, $this);
                
                return;
            }
        }

        BaseController::view('404')->render();;
    }

    public function route($routeName, $routeParams = []) {
        return $this->router->generate($routeName, $routeParams);
    }
}