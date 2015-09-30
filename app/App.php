<?php

namespace app;

use app\controllers\SiteController;
use app\controllers\ErrorController;

class App
{

    private $_csrf;

    public function __construct()
    {
        $this->setCsrf(bin2hex(openssl_random_pseudo_bytes(16)));
        setcookie("_csrf", $this->_csrf);
    }

    public function setCsrf($value) 
    {
        // if (isset($_COOKIE['_csrf'])) {
        //     $this->_csrf = $_COOKIE['_csrf'];
        // }

        $this->_csrf = $value;
    }

    public function getCsrf() 
    {
        return $this->_csrf;
    }

    public function run() 
    {
        $site = new SiteController();
        switch ($_SERVER["REQUEST_URI"]) {
            case '/':
            case '/home':
                return $site->actionIndex();
                break;

            case '/profile':
                return $site->actionProfile();
                break;

            case '/login':
                return $site->actionLogin();
                break;

            case '/signup':
                return $site->actionSignup();
                break;

            case '/email-unique':
                return $site->actionEmailUnique();
                break;

            case '/verify-password':
                return $site->actionVerifyPassword();
                break;

            case '/logout':
                return $site->actionLogout();
                break;

            case '/400':
                $error = new ErrorController(400);
                return $error->actionIndex();
                break;

            case '/403':
                $error = new ErrorController(403);
                return $error->actionIndex();
                break;
            
            default:
                $error = new ErrorController(404);
                return $error->actionIndex();
                break;
        }
    }
}
