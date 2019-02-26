<?php

namespace App\Controller;

use App\Service\Users;
use App\Service\Articles;
use DI\Container;
use Framework\Interfaces\RenderInterfaces;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\GetField;
use Framework\Flash;

class ModifyArticleController
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
     * ModifyArticleController constructor.
     *
     * @param Users $user
     * @param Articles $article
     */
    public function __construct(Users $user, Articles $article) {
        $this->users = $user;
        $this->article = $article;
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
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Container $container)
    {
        if (array_key_exists('auth', $_SESSION)){
            $posts = $this->users->allArticlesByPseudo($_SESSION['auth']->getPseudo('pseudo'));
            $articles = $this->article->getArticleWithPseudo($_SESSION['auth']->getPseudo('pseudo'));

            if ($request->getMethod() === 'GET') {
                $view = $container->get(RenderInterfaces::class)->render('ModifyArticle', ['posts' => $posts, 'articles' => $articles]);
                $response->getBody()->write($view);
            }
        }
        return $response;
    }


}