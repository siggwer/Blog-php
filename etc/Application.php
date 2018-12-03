<?php


namespace Framework;

use DI\Container;
use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Interfaces\ApplicationInterface;
use App\Controller\NotFoundController;

class Application implements ApplicationInterface
{
    /**
     * @var Container @container
     */
    private $container;

    /**
     * @var array
     */
    private $routes = [];

    /**
     * @throws \Exception
     */
    public function init()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);
        //$containerBuilder->addDefinitions(__DIR__.'/../configs/dic/database.php');
        //$containerBuilder->addDefinitions(__DIR__.'/../configs/dic/repositories.php');
        $containerBuilder->addDefinitions(__DIR__.'/../etc/Render.php');
        //$containerBuilder->addDefinitions(__DIR__. '/../configs/dic/SwiftMailer.php');
        $this->container = $containerBuilder->build();
        $this->loadRoutes();
    }

        /**
     * @param array $request
     * @return NotFoundController
     */
    public function handleRequest(array $request = [])
    {
        foreach ($this->routes as $route) {
            $this->catchParams($route->getParams(), $request['REQUEST_URI'], $route);
            if ($request['REQUEST_URI'] === $route->getPath()) {
                $controller = $route->getController();
                $class = new $controller();
                return $class($route->getParams());
            }
        }

        $controller = new NotFoundController();
        return $controller();
    }

    /**
     * @param array $params
     * @param string $request
     * @param Route $route
     */
    private function catchParams(array $params, string $request, Route &$route) {
        if (isset($params) && !empty($params)) {
            foreach ($params as $key => $regex) {
                preg_match(sprintf('#%s#', $regex), $request, $result);
                if (!empty($result)) {
                    $route->addParam($key, $result[0]);
                    $route->setPath(strtr($route->getPath(), [sprintf('{%s}', $key) => $result[0]]));
                }
            }
        }
    }

    /**
     *
     */
    private function loadRoutes() {
        $routes = include __DIR__ . '/../config/route.php';

        if (is_array($routes)) {
            foreach ($routes as $route) {
                $this->routes[] = new Route($route['path'], $route['controller'], $route['params'] ?? []);
            }
        }
    }

}