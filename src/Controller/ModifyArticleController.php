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
        if (array_key_exists('auth', $_SESSION)){
            $posts = $this->users->allArticlesByPseudo($_SESSION['auth']->getPseudo('pseudo'));
            $articles = $this->article->getArticleWithPseudo($_SESSION['auth']->getPseudo('pseudo'));

            if ($articles && $posts === false) {
                $this->setFlash("danger", "Article inconnu");
                return new Response(301, [
                    'Location' => '/account'
                ]);
            }

            if ($request->getMethod() === 'GET') {
                $view = $container->get(RenderInterfaces::class)->render('ModifyArticle', ['posts' => $posts, 'articles' => $articles]);
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

        $path = '/modifyArticle/'.$articles['id'];

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
        var_dump($contentLength);
        exit;
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

        $updatePost = $this->article->updatePost([
            'id' => $articles['id'],
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