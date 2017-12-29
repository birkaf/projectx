<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require __DIR__ . '/autoload.php';
session_start();
define('ROOT', dirname(__FILE__));
$router = new App\Router();
$router->run();