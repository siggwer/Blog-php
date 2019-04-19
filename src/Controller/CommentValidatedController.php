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

    /**
     * @param ServerRequestInterface $request
     * @param Container $container
     *
     * @return Response
     *
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \SendGrid\Mail\TypeException
     */
    public function __invoke(
        ServerRequestInterface $request,
        Response $response,
        Container $container
    ) {
        $comments = $this->comment->getCommentForvalidated(
            $request->getAttribute('comments', 0)
        );

        $email = $comments['email'];
        $user = explode('@', $email)[0];

        $commentValidated = $this->comment->validatedComment($request->getAttribute('comments'));


        if ($commentValidated) {
            $this->setFlash('success', 'Le commentaire a bien été validé');
        } else {
            $this->setFlash('warning', 'Un problème est survenue');
        }

        $renderHtml = $container->get(RenderInterfaces::class)->render(
            'mailValidatedComment',
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
            'Validation du commentaire',
            $from,
            $to,
            'mailValidatedComment',
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
                 la validation du commentaire'
        );
        return new Response(
            301,
            [
            'Location' => '/adminaccount'
            ]
        );
    }
}
