<?php


namespace App\Controller;

use DI\Container;
use Framework\Interfaces\RenderInterfaces;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Flash;
use Framework\GetField;
use Framework\MailHelper;

class ContactController
{
    use Flash, GetField;

    /**
     * @var
     */
    private $mailHelper;

    /**
     * ContactController constructor.
     *
     * @param MailHelper $mailHelper
     */
    public function __construct(MailHelper $mailHelper)
    {
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
            $view = $container->get(RenderInterfaces::class)->render('Contact');
            $response->getBody()->write($view);

            return $response;
        }

        $name = $this->getField('name');
        $firstName = $this->getField('firstname');
        $email = $this->getField('email');
        $message = $this->getField('message');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setFlash("danger", "Votre adresse n'est pas valide");
            return new Response(
                301,
                [
                'Location' => '/contact'
                ]
            );
        }


        $nameLength = strlen($name);
        if (empty($name) || $nameLength < 4) {
            $this->setFlash(
                "danger",
                "Votre nom doit contenir au moins 4 caractères
                 ou ne doit pas être vide"
            );
            return new Response(
                301,
                [
                'Location' => '/contact'
                ]
            );
        }

        $firstNameLength = strlen($firstName);
        if (empty($firstName) || $firstNameLength < 4) {
            $this->setFlash(
                "danger",
                "Votre nom doit contenir au moins 4 caractères
                 ou ne doit pas être vide"
            );
            return new Response(
                301,
                [
                'Location' => '/contact'
                ]
            );
        }

        $messageLength = strlen($message);
        if ($messageLength < 50) {
            $this->setFlash(
                "danger",
                "Votre message doit contenir au minimum 50 caractères"
            );
            return new Response(
                301,
                [
                'Location' => '/contact'
                ]
            );
        }

        $from = [
            'email' => 'test@yopmail.com',
            'name' => 'admin',
        ];
        $to = [
            'email' => $email,
            'name' =>  explode('@', $email)[0],
        ];

        $result = $this->mailHelper->sendMail(
            'Confirmation de votre message',
            $from,
            $to,
            'mailContact'
        );

        if (!$result->statusCode() === 202) {
            $this->setFlash(
                'danger',
                'Le mail n\'a pas pu être envoyé.'
            );
        }
        $this->setFlash(
            'success',
            'Merci pour votre message nous vous répondrons
                 dans les meilleures délais.'
        );
        return new Response(
            301,
            [
                'Location' => '/'
            ]
        );
    }
}
