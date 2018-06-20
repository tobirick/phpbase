<?php
namespace Core;

class Router {
    private $namespace = 'App\Controllers\\';
    private $controller;
    private $method;
    private $params;
    private $match;

    public function __construct($router) {
        $this->match = $router->match();

        $this->matchRoute();
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
}