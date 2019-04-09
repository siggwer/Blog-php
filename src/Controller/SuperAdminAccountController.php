<?php

namespace App\Controller;

use App\Service\Users;
use App\Service\Articles;
use App\Service\Comments;
use DI\Container;
use Framework\Interfaces\RenderInterfaces;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\CheckAuthAdmin;
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
     * @var
     */
    private $checkAuthAdmin;

    /**
     * SuperAdminAccountController constructor.
     *
     * @param Users $user
     * @param Articles $article
     * @param Comments $comment
     */
    /**
     * SuperAdminAccountController constructor.
     *
     * @param Users    $user
     * @param Articles $article
     * @param Comments $comment
     */
    public function __construct(
        Users $user,
        Articles $article,
        Comments $comment,
        checkauthAdmin $checkAuth
    ) {
        $this->users = $user;
        $this->article = $article;
        $this->comment = $comment;
        $this->checkAuthAdmin = $checkAuth;
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
        $this->checkAuthAdmin->checkAuthentification();


        $posts = $this->users->allusers();
        $articles = $this->article->home();
        $comments = $this->comment->allComments();


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
