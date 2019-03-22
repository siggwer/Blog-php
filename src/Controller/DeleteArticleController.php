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
use Framework\MailHelper;

class DeleteArticleController
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
    private $mailHelper;

    /**
     * DeleteArticleController constructor.
     *
     * @param Users $user
     * @param Articles $article
     * @param Comments $comment
     * @param MailHelper $mailHelper
     */
    public function __construct(Users $user,
                                Articles $article,
                                Comments $comment,
                                MailHelper $mailHelper)
    {
        $this->users = $user;
        $this->article = $article;
        $this->comment = $comment;
        $this->mailHelper = $mailHelper;
    }

    public function __invoke(ServerRequestInterface $request,
                             ResponseInterface $response,
                             Container $container)
    {
        if(array_key_exists('auth', $_SESSION)){
            $posts = $this->users->allArticlesByPseudo(
                $_SESSION['auth']->getPseudo());
            $comments = $this->comment->getCommentId(
                $request->getAttribute('articles', 0));
            $articles = $this->article->getArticleWithId(
                $request->getAttribute('articles', 0));

            if ($posts && $articles === false) {
                $this->setFlash("danger", "Article inconnu");
                return new Response(301, [
                    'Location' => '/account'
                ]);
            }

            if($request->getMethod() === 'GET') {
                $view = $container->get(RenderInterfaces::class)->render(
                    'DeleteArticle', ['posts' => $posts,
                    'articles' => $articles, 'comments' => $comments]);
                $response->getBody()->write($view);
                return $response;
            }
        }

        if(isset($articles['id'])  === true){
            $deleteArticle = $this->article->deleteArticle($articles['id']);
       }

        if($deleteArticle){
            $this->setFlash('success','Votre article a bien été supprimé');
        }else{
            $this->setFlash('warning','Un problème est survenue');
        }

        if(isset($comments['article_id']) === true){
            $deleteComment = $this->comment->deleteComment($comments['article_id']);
        }

        if($deleteComment){
            $this->setFlash('success','Votre article et commentaire ont bien été supprimés');
        }else{
            $this->setFlash('warning','Un problème est survenue');
        }
        return new Response(301, [
            'Location' => '/account'
        ]);
    }
}