<?php


use App\Repository\CommentRepository;
use App\Repository\Interfaces\ArticleRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
//use App\Repositories\PdoCommentRepository;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Repository\Interfaces\CommentRepositoryInterface;
use function \DI\object as di_object;

return [
    ArticleRepositoryInterface::class => di_object(ArticleRepository::class),
    //PostRepositoriesInterface::class => di_object(PdoPostRepository::class),
    CommentRepositoryInterface::class => di_object(CommentRepository::class),
    UserRepositoryInterface::class => di_object(UserRepository::class)
];
