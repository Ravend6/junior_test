<?php
session_start();
require ('../vendor/autoload.php');

use app\App;

$app = new App();

echo $app->run();