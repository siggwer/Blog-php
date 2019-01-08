<?php


namespace App\Controller;

use DI\Container;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romss\Flashable;
use Romss\GetField;
use Romss\Render\RenderInterface;

class ContactController
{
    use Flashable, GetField;
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param Container $container
     * @return ResponseInterface
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Container $container)
    {
        if ($request->getMethod() === 'GET') {
            $view = $container->get(RenderInterface::class)->render('Contact');
            $response->getBody()->write($view);

            return $response;
        }

        $name = $this->getField('name');
        $email = $this->getField('email');
        $content = $this->getField('content');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->setFlash("danger", "Votre adresse n'est pas valide");
            return new Response(301, [
                'Location' => '/contact'
            ]);
        }


        $nameLength = strlen($name);
        if (empty($name) || $nameLength < 4 ) {
            $this->setFlash("danger", "Votre nom doit contenir au moins 4 caractères ou ne doit pas être vide");
            return new Response(301, [
                'Location' => '/contact'
            ]);
        }

        $contentLength = strlen($content);
        if ($contentLength < 50) {
            $this->setFlash("danger", "Votre message doit contenir au minimum 50 caractères");
            return new Response(301, [
                'Location' => '/contact'
            ]);
        }

        // Connexion au smtp
        $transport = $container->get(Swift_SmtpTransport::class);

        // Container du mail
        $mailer = new Swift_Mailer($transport);

        // Le message à envoyer
        $message = new Swift_Message($name);
        $message
            ->setFrom(['localhost@test' => 'Admin'])
            ->setTo([$email => $name])
            ->setBody($content);

        $result = $mailer->send($message);
        if ($result) {
            $this->setFlash('success', 'Merci pour votre message nous vous répondrons dans les meilleures délais');
        }
        return new Response(301,[
            'Location' => '/'
        ]);
    }
}