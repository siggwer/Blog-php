<?php

namespace App\Controller;

use App\Service\Users;
use App\Service\Articles;
use App\Service\Comments;
use DI\Container;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\GetField;
use Framework\Flash;
use Framework\MailHelper;

class CommentValidatedController
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
     * CommentValidatedController constructor.
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
    public function __invoke(ServerRequestInterface $request,
                             ResponseInterface $response,
                             Container $container)
    {
        if(array_key_exists('auth', $_SESSION)){
            $posts = $this->users->allArticlesByPseudo(
                $_SESSION['auth']->getPseudo());
            $comments = $this->comment->getCommentForvalidated(
                $request->getAttribute('comments', 0));
        }

        if(isset($posts) && $comments) {
            $comments['validated'] = 1;
        }

        $email = $comments['email'];

        $commentValidated = $this->comment->validatedComment($comments);


        if($commentValidated){
            $this->setFlash('success','Le commentaire a bien été validé');
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

        $result = $this->mailHelper->sendMail(
            'Validation du commentaire',
            $from, $to, 'mailVerify');
        if ($result->statusCode() === 202) {
            $this->setFlash(
                'success',
                'Un email a été envoyé pour confirmer
                 la validation du commentaire');
        }

        return new Response(301, [
            'Location' => '/adminaccount'
        ]);
    }

}