<?php

session_start();

use Framework\Application;
//use Framework\Router;

require_once __DIR__ . '/../vendor/autoload.php';

//$router = new Router();
//$router->handleRequest($_SERVER);
//var_dump($router);

$sessionId = session_id();
$cookieId = $_COOKIE['PHPSESSID'] ?? 0;

if ($sessionId === $cookieId) {
    session_regenerate_id(true);
    $sessionId = session_id();
}

if (empty($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
}
    $_SESSION['counter'] += 1;

try {
    $app = new Application();
    $app->init();
    $app->handleRequest();

} catch (Exception $exception) {
    var_dump($exception->getMessage());
}