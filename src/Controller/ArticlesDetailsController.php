<?php

//declare(strict_types=1);

namespace App\Controller;

use App\Model\Articles;
use App\Model\Comments;
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
     * @param Comments $comment
     */
    public function __construct(Articles $articles, Comments $comment)
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
        $articles = $this->articles->getArticleWithId($request->getAttribute('articles', 0));
        $comments = $this->comment->getCommentId($request->getAttribute('articles', 0));
        $view = $container->get(RenderInterfaces::class)->render('articles', ['articles' => $articles, 'comments' => $comments]);
        $response->getBody()->write($view);
        return $response;
    }
}