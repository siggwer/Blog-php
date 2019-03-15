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
        'methods' => ['GET','POST'],
        'path' => '/article_details/{articles:[0-9]+}',
        'controller' => App\Controller\ArticlesDetailsController::class,
        'middlewares' => []
    ],
    'login' => [
        'methods' => ['GET','POST'],
        'path' => '/login',
        'controller' => App\Controller\LoginController::class,
        'middlewares' => []
    ],
    'register' => [
        'methods' => ['GET','POST'],
        'path' => '/register',
        'controller' => App\Controller\RegisterController::class,
        'middlewares' => []
    ],
    'logout' => [
        'methods' => ['GET'],
        'path' => '/logout',
        'controller' => App\Controller\LogOutController::class,
        'middlewares' => []
    ],
    'account' => [
        'methods' => ['GET','POST'],
        'path' => '/account',
        'controller' => App\Controller\AdministrationAccount::class,
        'middlewares' => [\Framework\ConfMiddleware::class]
    ],
    'create' => [
        'methods' => ['GET','POST'],
        'path' => '/create',
        'controller' => App\Controller\CreateArticleController::class,
        'middlewares' => [\Framework\ConfMiddleware::class]
    ],
    'update' => [
        'methods' => ['GET','POST'],
        'path' => '/update/{articles:[0-9]+}',
        'controller' => App\Controller\UpdateArticleController::class,
        'middlewares' => [\Framework\ConfMiddleware::class]
    ],
    'comment' => [
        'methods' => ['GET','POST'],
        'path' => '/comment/{articles:[0-9]+}',
        'controller' => App\Controller\CommentController::class,
        'middlewares' => [\Framework\ConfMiddleware::class]
    ],
    'contact' => [
        'methods' => ['GET', 'POST'],
        'path' => '/contact',
        'controller' => App\Controller\ContactController::class,
        'middlewares' => []
    ],
    'verifyToken' =>[
        'methods' =>['GET'],
        'path' => '/verify/{id:[0-9]+}-{token:[a-z\-0-9]+}',
        'controller' => App\Controller\VerificationEmail::class,
        'middlewares' => []
    ]
];