<?php

//declare(strict_types=1);

namespace App\Controller;

use App\Service\Articles;
use App\Service\Comments;
use DI\Container;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Interfaces\RenderInterfaces;
use Framework\GetField;
use Framework\Flash;

class ArticlesDetailsController
{
    use GetField, Flash;

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
     *
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
     *
     * @return ResponseInterface
     *
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __invoke(ServerRequestInterface $request,
                             ResponseInterface $response,
                             Container $container)
    {
        $articles = $this->articles->getArticleWithId($request->getAttribute(
            'articles', 0));
        $comments = $this->comment->getCommentId($request->getAttribute(
            'articles', 0));

        if($articles && $comments === false) {
            $this->setFlash("danger", "Article inconnu");
            return new Response(301, [
                'Location' => '/'
            ]);
        }

        if($request->getMethod() === 'GET') {
            $view = $container->get(RenderInterfaces::class)->render('articles',
                ['articles' => $articles, 'comments' => $comments]);
            $response->getBody()->write($view);
            return $response;
        }

        $author = $this->getField('author');
        $comment = $this->getField('commentaire');

        $path = '/article_details/' . $articles['id'];

        $authorLength = strlen($author);
        if($authorLength < 4) {
            $this->setFlash("danger",
                "Votre nom doit contenir au moins 4 caractères");
            return new Response(301, [
                'Location' => $path
            ]);
        }
        $commentLength = strlen($comment);
        if($commentLength < 3) {
            $this->setFlash("danger",
                "Votre commentaire doit contenir au minimum 3 caractères");
            return new Response(301, [
                'Location' => $path
            ]);
        }

        if(array_key_exists('auth', $_SESSION)) {
        $addComment = $this->comment->insertComment([
            //'id' => $comments['id'],
            'author' => $author,
            'comments' => $comment,
            'article_id' => $articles['id']
        ]);
        }else{
            $this->setFlash('warning',
                'Vous devez être connecté pour ajouter un commentaire');
            return new Response(301, [
                'Location' => '/login'
            ]);
        }

        if($addComment){
            $this->setFlash('success',
                'Votre commentaire est en cours de modération');
        }else{
            $this->setFlash('warning','Un problème est survenue');
        }
        return new Response(301, [
            'Location' => $path
        ]);
    }
}