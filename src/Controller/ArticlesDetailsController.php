<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Articles;
use App\Model\Comment;
use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Interfaces\RenderInterfaces;
class ArticlesDetailsController
{
    /**
     * @var $articles
     */
    private $articles;

    /**
     * @var $comment
     */
    private $comment;

    /**
     * ArticlesDetailsController constructor.
     * @param Articles $articles
     * @param Comment $comment
     */
    public function __construct(Articles $articles, Comment $comment)
    {
        $this->articles = $articles;
        $this->comment = $comment;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param Container $container
     * @return ResponseInterface
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Container $container)
    {
        $comments = $this->comment->getCommentId($request->getAttribute('articleId', 0));
        $article = $this->articles->getArticleWithId($request->getAttribute('article', 0));
        $view = $container->get(RenderInterfaces::class)->render('articles', ['article' => $article, 'comments' => $comments]);
        $response->getBody()->write($view);
        return $response;
    }
}