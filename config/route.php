<?php

// All routes
return [
    'home' => [
        'methods' => ['GET'],
        'path' => '/',
        'controller' => App\Controller\HomeController::class,
        'middlewares' => []
    ],
    'article_details' => [
        'methods' => ['GET'],
        'path' => '/article_details/{articles:[0-9]+}',
        'controller' => App\Controller\ArticlesDetailsController::class,
        //'params' => [
            //'id' => '\d+'
        //]
        'middlewares' => []
    ],
    'login' => [
        'methods' => ['GET', 'POST'],
        'path' => '/login',
        'controller' => App\Controller\LoginController::class,
        'middlewwares' => []
    ]
];