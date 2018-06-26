<?php
namespace Core;

use Philo\Blade\Blade;

class View {
    private $views = __DIR__ . '/../App/Views';
    private $cache = __DIR__ . '/../cache';
    private $blade;
    private $template;
    private $args;
    private $shares;

    public function __construct($template, $args = [], $shares = '') {
        $this->template = $template;
        $this->args = $args;
        $this->shares = $shares;
    }

    public function buildTemplate() {
        $this->blade = new Blade($this->views, $this->cache);
        
        if($this->shares) {
            $this->generateShares();
        }

        $html = $this->blade->view()->make($this->template, $this->args)->render();

        return $html;
    }

    public function render() {
        $html = $this->buildTemplate();

        $buffer = $this->sanitaze($html);

        echo $buffer;
    }

    public function get() {
        $html = $this->buildTemplate();

        return $html;
    }

     public function sanitaze($buffer) {
        $search = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );
    
        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );
    
        $buffer = preg_replace($search, $replace, $buffer);
    
        return $buffer;
    } 

    public function generateShares() {
        foreach($this->shares as $shareKey => $shareValue) {
            $this->blade->view()->share($shareKey, $shareValue);
        }
    }
}