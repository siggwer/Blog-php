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
//use Swift_Mailer;
//use Swift_Message;
//use Swift_SmtpTransport;

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
     * @param Users $users
     * @param MailHelper $mailHelper
     */
    public function __construct(Users $users, MailHelper $mailHelper)
    {
        $this->MailHelper = $mailHelper;
        $this->users = $users;
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
        if ($request->getMethod() === 'GET') {
            $view = $container->get(RenderInterfaces::class)->render('register');
            $response->getBody()->write($view);
            return $response;
        }

        $pseudo = $this->getField('pseudo');
        $email = $this->getField('email');
        $password = $this->getField('password');
        $repassword = $this->getField('repassword');


        $users = $this->users->getUserByEmail($email);

        if (!addslashes(htmlspecialchars(htmlentities(trim($pseudo))))) {
            $this->setFlash("attention", "Votre pseudo n'est pas valide");
            return new Response(301, ['Location' => '/register']);
            var_dump($pseudo);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->setFlash("danger", "Votre adresse mail n'est pas valide");
            return new Response(301, [
                'Location' => '/register'
            ]);
        }

        if ($email === $users->email()){
            $this->setFlash("danger", "Vous êtes déjà enregistré avec cette adresse mail");
            return new Response(301, [
                'Location' => '/register'
            ]);
        }


        $passLength = strlen($password);
        if ($passLength < 8){
            $this->setFlash("danger", "Votre mot de passe doit contenir au minimum 8 caractères");
            return new Response(301, [
                'Location' => '/register'
            ]);
        }
        if ($password != $repassword){
            $this->setFlash("danger", "Le mot de passe de confirmation n'est pas identique à votre mot de passe");
            return new Response(301, [
                'Location' => '/'
            ]);
        }
        $tokenRegister = $this->generateToken();
        $passwordHash = password_hash($email.'#-$'.$password, PASSWORD_BCRYPT, ['cost' => 12]);

        $users = new User([
            'pseudo' => $pseudo,
            'password' => $passwordHash,
            'email' => $email,
            'email_token' => $tokenRegister
        ]);

        $userRegister = $this->users->registerUser($users);

        $renderHtml = $container->get(RenderInterfaces::class)->render('mailVerify', [
            'user' => $userRegister
        ]);
        $renderText = $container->get(RenderInterfaces::class)->render('mailVerify', [
            'user' => $userRegister
        ], 'text');

        //$conf = require __DIR__ . '/../../config/mail.php';

        // Create the Transport
        //$transport = $container->get(new Swift_SmtpTransport($conf['smtp'], $conf['port']))
            //->setUsername($conf['userName'])
            //->setPassword($conf['password']);

        // Connexion au smtp
        //$transport = $container->get(Swift_SmtpTransport::class);

        // Container du mail
        //$mailer =  $container->get(new \SendGrid('sengrid.api.key'));
        //$mailer = new Mail();


        // Le message à envoyer
        //$message = new \SendGrid\Mail\Subject('Confirmation de votre compte');
        //$message
            //->setFrom(['localhost@local.dev' => 'Admin localhost'])
            //->setTo([$email => explode('@', $email)[0]])
            //->setBody($renderHtml, 'text/html')
            //->addPart($renderText, 'text/plain');

        //$result = $mailer->send($message);
        //$result = $mailer->sendMail();

        //$subject = ('Confirmation de votre compte');
        //$from = ['localhost@local.dev' => 'Admin localhost'];
        //$to = [$email => explode('@', $email)[0]];
        //$template = ($renderHtml);

        //$result = $this->MailHelper->sendMail($subject['Confirmation de votre compte'], $from, $to, $template);

        $result = $this->MailHelper->sendMail('Confirmation de votre compte', ['localhost@local.dev' => 'Admin localhost'], [$email => explode('@', $email)[0]], 'mailVerify');
        if ($result) {
            $this->setFlash('success', 'Un email vous a été envoyé pour confirmer votre compte');
        }

        return new Response(301, [
            'Location' => '/'
        ]);
    }
}