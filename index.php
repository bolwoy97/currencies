<?php

// FRONT CONTROLLER

//ini_set('display_errors',1);
//error_reporting(E_ALL);

date_default_timezone_set('Europe/Kiev');
session_start();
define('ROOT', dirname(__FILE__));

require_once(ROOT.'/components/Autoload.php');

$router = new Router();
$router->run();


