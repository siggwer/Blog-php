<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\ArticleDetail;
use App\Model\Comment;
use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Interfaces\RenderInterfaces;
class ArticlesDetailsController
{
    /**
     * @var $articleDetail
     */
    private $articleDetail;

    /**
     * @var $comment
     */
    private $comment;

    /**
     * ArticlesDetailsController constructor.
     * @param ArticleDetail $articleDetail
     * @param Comment $comment
     */
    public function __construct(ArticleDetail $articleDetail, Comment $comment)
    {
        $this->articleDetail = $articleDetail;
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
        //$comments = $this->comment->getCommentId($request->getAttribute('articleId', 0));
        $article = $this->articleDetail->getArticleWithId($request->getAttribute('articleId', 0));
        var_dump($article);
        $view = $container->get(RenderInterfaces::class)->render('articles', ['article' => $article, 'comments' => $comments]);
        $response->getBody()->write($view);
        return $response;
    }
}