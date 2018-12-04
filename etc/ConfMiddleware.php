<?php


namespace Framework;

use DI\Container;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Flash;
class ConfMiddleware
{
    /**
     * @param ServerRequestInterface $request
     * @param Response $response
     * @param Container $container
     * @param $next
     * @return Response
     */
    public function __invoke(ServerRequestInterface $request, Response $response, Container $container, $next)
    {
        if (!isset($_SESSION['auth']) || $_SESSION['auth']->rank() <=1) {
            $this->setFlash("danger", "Vous devez être admin pour entrer");
            return new Response(301, [
                'Location' => '/'
            ]);
        }
        return $next($request, $response);
    }
}