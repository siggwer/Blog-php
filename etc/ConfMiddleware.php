<?php


namespace Framework;

use DI\Container;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class ConfMiddleware
{
    use Flash;

    /**
     * @param ServerRequestInterface $request
     * @param Response $response
     * @param Container $container
     * @param $next
     *
     * @return Response
     */
    public function __invoke(ServerRequestInterface $request, Response $response, Container $container, $next)
    {
        var_dump($_SESSION['auth']);
        //Verifier le var dump sur le projet de romain pour voir si le rank vient du model ou du service.

        if (!isset($_SESSION['auth']) || $_SESSION['auth']->rank() <= 1) {
            $this->setFlash("danger", "Vous devez être admin pour entrer");
            return new Response(301, [
                'Location' => '/'
            ]);
        }
        return $next($request, $response);
    }
}