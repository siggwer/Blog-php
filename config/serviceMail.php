<?php

use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\Interfaces\ArticleRepositoryInterface;
use App\Repository\Interfaces\CommentRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Repository\UserRepository;
use Framework\MailHelper;
use function DI\get as di_get;
use function DI\string as di_string;
use function \DI\object as di_object;

return [
    'sendgrid.api.key' => di_string('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'),

    MailHelper::class => di_object(MailHelper::class)->constructor(
        di_get('sendgrid.api.key')
    ),
    MailHelper::class => di_object(MailHelper::class),
    ArticleRepositoryInterface::class => di_object(ArticleRepository::class),
    //PostRepositoriesInterface::class => di_object(PdoPostRepository::class),
    CommentRepositoryInterface::class => di_object(CommentRepository::class),
    UserRepositoryInterface::class => di_object(UserRepository::class)
];
