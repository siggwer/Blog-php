<?php

// All routes
use App\Controller\HomeController;
//use App\Controller\ArticleDetailsController;
//use App\Controller\ContactController;

// All routes
return [
    'home' => [
        'path' => '/',
        'controller' => HomeController::class
    ],
];