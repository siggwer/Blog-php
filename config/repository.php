<?php

//use App\Repositories\CommentRepositoriesInterface;
use App\Repository\Interfaces\HomeRepositoryInterface;
//use App\Repositories\UserRepositoriesInterface;
//use App\Repositories\PdoCommentRepository;
use App\Repository\HomeRepository;
//use App\Repositories\PdoUserRepository;

use function \DI\object as di_object;

return [
    HomeRepositoryInterface::class => di_object(HomeRepository::class),
    //PostRepositoriesInterface::class => di_object(PdoPostRepository::class),
    //CommentRepositoriesInterface::class => di_object(PdoCommentRepository::class),
    //UserRepositoriesInterface::class => di_object(PdoUserRepository::class)
];