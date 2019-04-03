<?php

namespace App\Controller;

use App\Service\Users;
use App\Service\Articles;
use App\Service\Comments;
use DI\Container;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Interfaces\RenderInterfaces;
use Framework\GetField;
use Framework\Flash;

class CommentController
{
    use GetField, Flash;

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
    private $users;

    /**
     * CommentController constructor.
     *
     * @param Users    $user
     * @param Articles $article
     * @param Comments $comment
     */
    public function __construct(Users $user, Articles $article, Comments $comment)
    {
        $this->users = $user;
        $this->article = $article;
        $this->comment = $comment;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param Container              $container
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
        if (array_key_exists('auth', $_SESSION)) {
            $posts = $this->users->allArticlesByPseudo(
                $_SESSION['auth']->getPseudo()
            );
            $articles = $this->article->getArticleWithId(
                $request->getAttribute('articles', 0)
            );
            $comments = $this->comment->getComment(
                $request->getAttribute('articles', 0)
            );

            if ($posts && $articles === false) {
                $this->setFlash("danger", "Article inconnu");
                return new Response(
                    301,
                    [
                    'Location' => '/account'
                    ]
                );
            }

            if ($request->getMethod() === 'GET') {
                $view = $container->get(RenderInterfaces::class)->render(
                    'modifyComment',
                    ['posts' => $posts,
                        'articles' => $articles,
                    'comments' => $comments]
                );
                $response->getBody()->write($view);
            }
        }
        return $response;
    }
}
