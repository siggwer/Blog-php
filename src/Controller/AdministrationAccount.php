<?php

namespace App\Controller;

use App\Service\Users;
use App\Service\Articles;
use App\Service\Comments;
use DI\Container;
use Framework\CheckAuthUser;
use GuzzleHttp\Psr7\Response;
use Framework\Interfaces\RenderInterfaces;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\GetField;
use Framework\Flash;

class AdministrationAccount
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
    private $checkAuthUser;

    /**
     * AdministrationAccount constructor.
     *
     * @param Users    $user
     * @param Articles $article
     * @param Comments $comment
     */
    public function __construct(
        Users $user,
        Articles $article,
        Comments $comment,
        checkauthUser $checkAuth
    ) {
        $this->users = $user;
        $this->article = $article;
        $this->comment = $comment;
        $this->checkAuthUser = $checkAuth;
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
        $this->checkAuthUser->checkAuthentification();

        if (array_key_exists('auth', $_SESSION)) {
            $posts = $this->users->allArticlesByPseudo(
                $_SESSION['auth']->getPseudo('pseudo')
            );
            $articles = $this->article->getArticleWithPseudo(
                $_SESSION['auth']->getPseudo('pseudo')
            );
        }

        if ($request->getMethod() === 'GET') {
            $view = $container->get(RenderInterfaces::class)->render(
                'administration',
                ['posts' => $posts, 'articles' => $articles
                ]
            );
            $response->getBody()->write($view);
        }
        return $response;
    }
}
