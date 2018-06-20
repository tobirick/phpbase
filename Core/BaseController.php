<?php
namespace Core;

class BaseController {
    private static $template;
    private static $args;
    private static $shares;

    public static function view($template, $args = []) {
        self::$template = $template;
        self::$args = $args;

        return new static();
    }

    public static function render() {
        if(isset($_SESSION['csrf_token'])) {
            Shares::add('csrf_token', $_SESSION['csrf_token']);
        }

        if(isset($_SESSION['flash'])) {
            Shares::add('flash', $_SESSION['flash']);
            Flash::remove();
        }

        // Add your shares (Available in every View)
        Shares::add('share1', 'Share Test 1');
        Shares::add('share2', 'Share Test 2');
        self::$shares = Shares::get();
        
        $view = new View(self::$template, self::$args, self::$shares);
        $view->render();
    }

    public static function redirect($url) {
        $redirectTo = $url;
        header('Location: ' . $redirectTo  );
    }
}