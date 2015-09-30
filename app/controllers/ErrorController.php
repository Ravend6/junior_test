<?php

namespace app\controllers;

use app\lib\Controller;

class ErrorController extends Controller 
{

    public function __construct($errorCode) 
    {
        $this->errorCode = $errorCode;
        if (isset($_COOKIE['language']) and $_COOKIE['language'] === 'ru') {
            $this->title = "Ошибка {$errorCode}";
        } else {
            $this->title = "Error {$errorCode}";
        }
    }

    public function actionIndex() 
    {
        http_response_code($this->errorCode);
        return $this->render('error', ['title' => $this->title]);
    }
}