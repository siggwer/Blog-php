<?php

namespace App\Controller;

use DI\Container;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Flash;

class LogOutController
{
    use Flash;

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param Container              $container
     *
     * @return Response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Container $container)
    {
        unset($_SESSION['auth']);
        setcookie('remember', '', -1, '/', null, false, true);
        $this->setFlash('success', 'Vous êtes bien déconnecté');
        return new Response(
            301,
            [
            'Location' => '/'
            ]
        );
    }
}
