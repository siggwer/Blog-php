<?php

namespace App\Controller;

use App\Service\Users;
use App\Service\Articles;
use DI\Container;
use GuzzleHttp\Psr7\Response;
use Framework\Interfaces\RenderInterfaces;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\GetField;
use Framework\Flash;
use Framework\MailHelper;

class addArticle
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
    private $mailHelper;

    /**
     * ModifyArticleController constructor.
     *
     * @param Users $user
     * @param Articles $article
     * @param MailHelper $mailHelper
     */
    public function __construct(Users $user, Articles $article, MailHelper $mailHelper)
    {
        $this->users = $user;
        $this->article = $article;
        $this->mailHelper = $mailHelper;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param Container $container
     *
     * @return Response
     *
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \SendGrid\Mail\TypeException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Container $container)
    {
        if(!array_key_exists('auth', $_SESSION)) {
                $this->setFlash("danger", "Merci de vous connecter pour ajouter un article.");
                return new Response(301, [
                    'Location' => '/login'
                ]);

            if (array_key_exists('auth', $_SESSION)) {
                $view = $container->get(RenderInterfaces::class)->render('addArticle');
                $response->getBody()->write($view);
                return $response;
            }
        }

        $title = $this->getField('title');
        $chapo = $this->getField('chapo');
        $content = $this->getField('content');
        $author = $this->getField('author');
        $author_id = $_SESSION['auth']->getId('id');
        $email = $_SESSION['auth']->getEmail('email');

        $path = '/add/';

        $titleLength = strlen($title);
        if ( $titleLength < 10 ) {
            $this->setFlash("danger", "Votre titre doit contenir au moins 10 caractères ou ne doit pas être vide");
            return new Response(301, [
                'Location' => $path
            ]);
        }

        $chapoLength = strlen($chapo);
        if ($chapoLength < 20 ) {
            $this->setFlash("danger", "Le chapoô doit contenir au moins 20 caractères ou ne doit pas être vide");
            return new Response(301, [
                'Location' => $path
            ]);
        }

        $contentLength = strlen($content);
        if ($contentLength < 30) {
            $this->setFlash("danger", "Votre message doit contenir au minimum 50 caractères ou ne doit pas être vide");
            return new Response(301, [
                'Location' => $path
            ]);
        }

        $authorLength = strlen($author);
        if ($authorLength < 4) {
            $this->setFlash("danger", "Auteur doit contenir au minimum 4 caractères ou ne doit pas être vide");
            return new Response(301, [
                'Location' => $path
            ]);
        }

        $updatePost = $this->article->insertPost([
            //'id' => $articles['id'],
            //'img' => $imgName,
            'title' => $title,
            'chapo' => $chapo,
            'content' => $content,
            'author' => $author,
            'author_id' => $author_id
        ]);

        if ($updatePost){
            $this->setFlash('success','Votre article a bien été modifié');
        }else{
            $this->setFlash('warning','Un problème est survenue');
        }

        $from =[
            'email' => 'test@yopmail.com',
            'name' => 'admin',
        ];

        $to = [
            'email' => $email,
            'name' =>  explode('@', $email)[0],
        ];

        $result = $this->mailHelper->sendMail('Modification de l\'article.', $from, $to, 'mailVerify');
        if ($result->statusCode() === 202) {
            $this->setFlash('success', 'Un email vous a été envoyé pour confirmer la modification de l\'article.');
        }

        return new Response(301, [
            'Location' => '/account'
        ]);
    }

}