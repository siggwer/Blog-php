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
     * @param Users      $user
     * @param Articles   $article
     * @param Comments   $comment
     * @param MailHelper $mailHelper
     */
    public function __construct(
        Users $user,
        Articles $article,
        Comments $comment,
        MailHelper $mailHelper
    ) {
        $this->users = $user;
        $this->article = $article;
        $this->comment = $comment;
        $this->mailHelper = $mailHelper;
    }

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
            $comments = $this->comment->getCommentId(
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
        }

        $email = $articles['email'];
        $user = $_SESSION['auth']->getPseudo('pseudo');

        if (isset($articles['id'])  === true) {
            $deleteArticle = $this->article->deleteArticle($articles['id']);
        }

        if ($deleteArticle) {
            $this->comment->deleteComment($comments['article_id']);
            $this->setFlash('success', 'Votre article a bien été supprimé');
        } else {
            $this->setFlash('warning', 'Un problème est survenue');
        }

        if ($deleteArticle) {
            $this->setFlash('success', 'Votre article a bien été supprimé');
        } else {
            $this->setFlash('warning', 'Un problème est survenue');
        }

        $renderHtml = $container->get(RenderInterfaces::class)->render(
            'mailDeleteArticle',
            [
                'user' => $user
            ]
        );

        $from =[
            'email' => 'test@yopmail.com',
            'name' => 'admin',
        ];

        $to = [
            'email' => $email,
            'name' =>  explode('@', $email)[0],
        ];

        $result = $this->mailHelper->sendMail(
            'Modification de l\'article.',
            $from,
            $to,
            'mailDeleteArticle',
            [
                'user' => $user
            ]
        );

        if (!$result->statusCode() === 202) {
            $this->setFlash(
                'danger',
                'Le mail n\'a pas pu être envoyé.'
            );
        }
        $this->setFlash(
            'success',
            'Un email a été envoyé pour confirmer
                 la suppression de l\'article.'
        );
        return new Response(
            301,
            [
                'Location' => '/account'
            ]
        );
    }
}
