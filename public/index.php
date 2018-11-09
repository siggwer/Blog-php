<?php
session_start();

use Framework\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();
$router->handleRequest($_SERVER);
var_dump($router);


