<?php

namespace App\Controller;

//use App\Repository\User;
use App\Service\Users;
use DI\Container;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\GetField;
use Framework\Flash;
use Framework\Token;
use Framework\Interfaces\RenderInterfaces;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
class RegisterController
{
    use Token, Flash, GetField;

    /**
     * @var
     */
    private $users;

    /**
     * RegisterController constructor.
     * @param Users $userServices
     */
    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Container $container)
    {
        if ($request->getMethod() === 'GET') {
            $view = $container->get(RenderInterfaces::class)->render('register');
            $response->getBody()->write($view);
            return $response;
        }

        $pseudo = $this->getField('pseudo');
        $email = $this->getField('email');
        $pass = $this->getField('password');
        $pass_confirm = $this->getField('repassword');


        $users = $this->users->getUserByEmail($email);

        if (addslashes(htmlspecialchars(htmlentities(trim($pseudo))))) {
            $this->setFlash("attention", "Votre pseudo n'est pas valide");
            return new Response(301, ['Location' => '/register']);
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


        $passLength = strlen($pass);
        if ($passLength < 8){
            $this->setFlash("danger", "Votre mot de passe doit contenir au minimum 8 caractères");
            return new Response(301, [
                'Location' => '/register'
            ]);
        }
        if ($pass != $pass_confirm){
            $this->setFlash("danger", "Le mot de passe de confirmation n'est pas identique à votre mot de passe");
            return new Response(301, [
                'Location' => '/'
            ]);
        }
        $tokenRegister = $this->generateToken();
        $passwordHash = password_hash($email.'#-$'.$pass, PASSWORD_BCRYPT, ['cost' => 12]);

        $users = new User([
            'pseudo' => $pseudo,
            'password' => $passwordHash,
            'email' => $email,
            'email_token' => $tokenRegister
        ]);

        $userRegister = $this->users->registerUser($users);

        $renderHtml = $container->get(RenderInterfaces::class)->render('Mails/verify', [
            'user' => $userRegister
        ]);
        $renderText = $container->get(RenderInterfaces::class)->render('Mails/verify', [
            'user' => $userRegister
        ], 'text');

        $conf = require __DIR__ . '/../../config/mail.php';

        // Create the Transport
        $transport = $container->get(new Swift_SmtpTransport($conf['smtp'], $conf['port']))
            ->setUsername($conf['userName'])
            ->setPassword($conf['password']);

        // Connexion au smtp
        //$transport = $container->get(Swift_SmtpTransport::class);

        // Container du mail
        $mailer = new Swift_Mailer($transport);

        // Le message à envoyer
        $message = new Swift_Message('Confirmation de votre compte');
        $message
            ->setFrom(['localhost@local.dev' => 'Admin localhost'])
            ->setTo([$email => explode('@', $email)[0]])
            ->setBody($renderHtml, 'text/html')
            ->addPart($renderText, 'text/plain');

        $result = $mailer->send($message);
        if ($result) {
            $this->setFlash('success', 'Un email vous a été envoyé pour confirmer votre compte');
        }

        return new Response(301, [
            'Location' => '/'
        ]);
    }
}