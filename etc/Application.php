<?php


namespace Framework;

use DI\Container;
use DI\ContainerBuilder;
use Framework\Interfaces\RenderInterfaces;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Interfaces\ApplicationInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route;

use function QuimCalpe\ResponseSender\send AS send_response;

class Application implements ApplicationInterface
{
    /**
     * @var Container @container
     */
    private $container;

    /**
     * @var ServerRequestInterface $request
     */
    private $request;

    /**
     * @var ResponseInterface $response
     */
    private $response;

    /**
     * @var array
     */
    private $middlewares;

    /**
     * @var FastRouteRouter $router
     */
    private $router;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->middlewares = [];
    }

    /**
     * @return mixed|void
     */
    public function init()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);
        $containerBuilder->addDefinitions(__DIR__ . '/../config/db.php');
        $containerBuilder->addDefinitions(__DIR__. '/../config/repository.php');
        $containerBuilder->addDefinitions(__DIR__ . '/../config/render.php');
        $containerBuilder->addDefinitions(__DIR__. '/../config/serviceMail.php');
        $containerBuilder->addDefinitions(__DIR__ . '/../config/mail.php');
        $this->container = $containerBuilder->build();
        $this->loadRoutes();
    }

    /**
     * @return mixed|void
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function handleRequest()
    {
        $this->request = ServerRequest::fromGlobals();
        $this->response = new Response();

        $route = $this->router->match($this->request);

        if ($route->isSuccess()) {
            foreach ($route->getMatchedParams() as $name => $value) {
                $this->request = $this->request->withAttribute($name, $value);
            }

            $middlewares = $this->middlewares[$route->getMatchedRouteName()];
            if ($middlewares === null) {
                $middlewares = [];
            }
            $middlewaresGlobals = (include __DIR__ . '/../config/middlewares.php');
            $middlewares = array_merge($middlewaresGlobals, $middlewares);

            $dispatcher = new Dispatcher($this->container, $middlewares);
            $dispatcher->pipe($route->getMatchedMiddleware());
            $result = $dispatcher->process($this->request, $this->response);

            $location = $result->getHeader('Location');

            if (!empty($location)) {
                header("HTTP/{$result->getProtocolVersion()} 301 Moved Permantly", false, 301);
                header('Location: ' . $location[0]);
                exit();
            }

            send_response($result);
        } else {
            $rendering = $this->container->get(RenderInterfaces::class)->render('404');
            send_response(new Response(404, [], $rendering));
        }
    }

    private function loadRoutes()
    {
        $this->router = new FastRouteRouter();

        $routes = (include __DIR__ . '/../config/route.php');
        foreach ($routes as $name => $route) {
            $routeAdd = new Route($route['path'], $route['controller'], $route['methods'], $name);
            $this->router->addRoute($routeAdd);

            $this->middlewares[$name] = $route['middlewares'];

        }
    }

}
