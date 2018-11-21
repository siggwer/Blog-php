<?php

// All routes
return [
    'home' => [
        'path' => '/',
        'controller' => App\Controller\HomeController::class
    ],
    'article_details' => [
        'path' => '/article_details/{id}',
        'controller' => App\Controller\ArticlesDetailsController::class,
        'params' => [
            'id' => '\d+'
        ]
    ],
];