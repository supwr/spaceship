<?php

error_reporting(E_ALL); 
ini_set('display_errors', 1);

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;



//ExceptionHandler::register();
//ErrorHandler::register();

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/controllers.php';
$app->run();
