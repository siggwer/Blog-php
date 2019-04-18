<?php

namespace App\Controller;

use App\Service\Users;
use App\Service\Articles;
use App\Service\Comments;
use DI\Container;
use GuzzleHttp\Psr7\Response;
use Framework\Interfaces\RenderInterfaces;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\GetField;
use Framework\Flash;

class SuperAdminAccountController
{
    use GetField, Flash;

    /**
     * @var
     */
    private $users;

    /**
     * @var
     */
    private $article;

    /**
     * @var
     */
    private $comment;

    /**
     * SuperAdminAccountController constructor.
     *
     * @param Users $user
     * @param Articles $article
     * @param Comments $comment
     */
    public function __construct(
        Users $user,
        Articles $article,
        Comments $comment
    ) {
        $this->users = $user;
        $this->article = $article;
        $this->comment = $comment;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param Container $container
     *
     * @return ResponseInterface
     *
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        Container $container
    ) {
        if(!array_key_exists('auth', $_SESSION)) {
        $this->setFlash(
        'warning',
        'Vous devez être connecté pour accéder à votre espace'
        );
        return new Response(
        301, [
        'Location' => '/login'
        ]
        );
        }

        if(array_key_exists('auth', $_SESSION)
        && $_SESSION['auth']->getRank() < 3
        ) {
        $this->setFlash('warning', 'Vous ne pouvez pas accéder à cette espace!');
        return new Response(
        301, [
        'Location' => '/'
        ]
        );
        }

        if (array_key_exists('auth', $_SESSION)) {
            $posts = $this->users->allusers();
            $articles = $this->article->home();
            $comments = $this->comment->allComments();
        }

        if ($request->getMethod() === 'GET') {
            $view = $container->get(RenderInterfaces::class)->render(
                'superAdmin',
                [
                    'posts' => $posts,
                    'articles' => $articles,
                'comments' => $comments]
            );
            $response->getBody()->write($view);
        }
        return $response;
    }
}
