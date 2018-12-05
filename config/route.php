<?php

// All routes
return [
    'home' => [
        'path' => '/',
        'methods' => ['GET'],
        'controller' => App\Controller\HomeController::class,
        'middlewares' => []
    ],
    'article_details' => [
        'path' => '/article_details/{id}',
        'controller' => App\Controller\ArticlesDetailsController::class,
        'params' => [
            'id' => '\d+'
        ]
    ],
];