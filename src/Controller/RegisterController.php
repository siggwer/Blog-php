<?php

namespace App\Controller;

use App\Model\User;
use App\Service\Users;
use DI\Container;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\GetField;
use Framework\Flash;
use Framework\Token;
use Framework\Interfaces\RenderInterfaces;
use Framework\MailHelper;

class RegisterController
{
    use Token, Flash, GetField;

    /**
     * @var
     */
    private $users;

    /**
     * @var
     */
    private $mailHelper;

    /**
     * RegisterController constructor.
     *
     * @param Users      $users
     * @param MailHelper $mailHelper
     */
    public function __construct(
        Users $users,
        MailHelper $mailHelper
    ) {
        $this->users = $users;
        $this->mailHelper = $mailHelper;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param Container $container
     *
     * @return Response|ResponseInterface
     *
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \SendGrid\Mail\TypeException
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        Container $container
    ) {
        if ($request->getMethod() === 'GET') {
            $view = $container->get(RenderInterfaces::class)->render('register');
            $response->getBody()->write($view);
            return $response;
        }

        $pseudo = $this->getField('pseudo');
        $email = $this->getField('email');
        $password = $this->getField('password');
        $repassword = $this->getField('repassword');


        $users = $this->users->getUserByPseudo($pseudo);


        if (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $pseudo)) {
            $this->setFlash('attention', "Votre pseudo n'est pas valide");
            return new Response(301, ['Location' => '/register']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setFlash(
                "danger",
                "Votre adresse mail n'est pas valide"
            );
            return new Response(
                301,
                [
                'Location' => '/register'
                ]
            );
        }

        if ($email === $users->getPseudo()) {
            $this->setFlash(
                "danger",
                "Vous êtes déjà enregistré avec ce pseudo"
            );
            return new Response(
                301,
                [
                'Location' => '/register'
                ]
            );
        }

        if ($pseudo === $users->getPseudo()) {
            $this->setFlash(
                "danger",
                "Vous êtes déjà enregistré avec ce pseudo"
            );
            return new Response(
                301,
                [
                    'Location' => '/register'
                ]
            );
        }


        $passLength = strlen($password);
        if ($passLength < 8) {
            $this->setFlash(
                "danger",
                "Votre mot de passe doit contenir au minimum 8 caractères"
            );
            return new Response(
                301,
                [
                'Location' => '/register'
                ]
            );
        }
        if ($password != $repassword) {
            $this->setFlash(
                "danger",
                "Le mot de passe de confirmation
                 n'est pas identique à votre mot de passe"
            );
            return new Response(
                301,
                [
                'Location' => '/register'
                ]
            );
        }
        $emailToken = $this->generateToken();

        $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        $users = new User(
            [
            'pseudo' => $pseudo,
            'password' => $passwordHash,
            'email' => $email,
            'emailToken' => $emailToken
            ]
        );

        $userRegister = $this->users->registerUser($users);

        $renderHtml = $container->get(RenderInterfaces::class)->render(
            'mailVerify',
            [
            'user' => $userRegister
            ]
        );

        $renderText = $container->get(RenderInterfaces::class)->render(
            'mailVerify',
            [
            'user' => $userRegister
            ],
            'text'
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
            'Confirmation de votre compte',
            $from,
            $to,
            'mailVerify',
            [
                'user' => $userRegister
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
                 la création de votre compte.'
        );
        return new Response(
            301,
            [
                'Location' => '/'
            ]
        );
    }
}
