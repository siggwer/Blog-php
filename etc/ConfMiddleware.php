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
        //var_dump($_SESSION['auth'],$container,$next);
        //print_r($_SESSION['auth']);
        //var_dump($container);
        //exit;

        if(array_key_exists('auth', $_SESSION)){
            if (!isset($_SESSION['auth'])) {
                //|| $_SESSION['auth']->getRank() <= 1
                $this->setFlash("danger", "Vous devez être admin pour entrer");
                return new Response(301, [
                    'Location' => '/'
                ]);
            }
            return $next($request, $response);
        }
    }
}