<?php

namespace app\lib;

use app\App;

class Controller
{

    public function render($view, $data = null) 
    {
        // $csrf = bin2hex(openssl_random_pseudo_bytes(16));
        global $app;
        if (isset($_COOKIE['_csrf'])) {
            $csrf = $app->getCsrf();
        } else {
            header('Location: /');
        }
        if ($data) {
            foreach ($data as $key => $value) {
                $$key = $value;

            }
        }

        ob_start();
        require(__DIR__ . '/../views/' . $view . '.php');
        return ob_get_clean();
        
    }
}