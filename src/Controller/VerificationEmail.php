<?php

namespace App\Controller;

use App\Service\Users;
use DateTime;
use DateTimeZone;
use DI\Container;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Flash;

class VerificationEmail
{
    use Flash;

    /**
     * @var
     */
    private $users;

    /**
     * VerificationEmail constructor.
     *
     * @param Users $users
     */
    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param Container              $container
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        Container $container
    ) {
        $userId = $request->getAttribute('id');
        $token = $request->getAttribute('token');

        $users = $this->users->getUserById($userId);

        if ($users === false || $users->email_token() != $token) {
            $this->setFlash(
                "danger",
                "Votre lien d'activation n'est pas valide"
            );
            return new Response(
                301,
                [
                'Location' => '/'
                ]
            );
        }

        $timezone = new DateTimeZone('Europe/Paris');
        $limit = new DateTime('-10 minute', $timezone);

        $registerAt = $users->register_at();
        if ($limit > $registerAt) {
            $this->setFlash(
                "warning",
                "Votre lien n'est plus valide"
            );
            return new Response(
                301,
                [
                'Location' => '/'
                ]
            );
        }

        $users->setEmail_token(null);
        $this->users->updateUser($users);

        $this->setFlash(
            "success",
            "Votre compte est actif. Vous pouvez vous connecter"
        );
        return new Response(
            301,
            [
            'Location' => '/'
            ]
        );
    }
}
