<?php

//use App\Repositories\CommentRepositoriesInterface;
use App\Repository\Interfaces\ArticleRepositoryInterface;
//use App\Repositories\UserRepositoriesInterface;
//use App\Repositories\PdoCommentRepository;
use App\Repository\ArticleRepository;
//use App\Repositories\PdoUserRepository;

use function \DI\object as di_object;

return [
    ArticleRepositoryInterface::class => di_object(ArticleRepository::class),
    //PostRepositoriesInterface::class => di_object(PdoPostRepository::class),
    //CommentRepositoriesInterface::class => di_object(PdoCommentRepository::class),
    //UserRepositoriesInterface::class => di_object(PdoUserRepository::class)
];