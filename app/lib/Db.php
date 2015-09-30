<?php

namespace app\lib;

class Db
{
    public $db;
    public $dbhost = 'localhost';
    public $dbname = 'junior';
    public $dbuser = 'junior_user';
    public $dbpassword = 'qwerty';


    public function __construct() 
    {   
        $this->db = new \PDO('mysql:host='. $this->dbhost . 
            ';dbname=' . $this->dbname, $this->dbuser, $this->dbpassword);
    }

}