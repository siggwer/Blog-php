<?php

declare(strict_types=1);

namespace Framework;

use Framework\Interfaces\RouterInterface;
use App\Controller\NotFoundController;

class Router
{
    private $routes = [];

    public function __construct()
    {
        $this->loadRoutes();
    }

    public function handleRequest(array $request = [])
    {
        foreach ($this->routes as $route)
            $this->catchParams($route->getParams(), $request['REQUEST_URI'], $route);
            if ($request['REQUEST_URI'] === $route->getPath()) {
                $controller = $route->getController();
                $class = new $controller();
                return $class($route->getParams());
            }

            $controller = new NotFoundController();
            return $controller;
    }

    private function catchParams(array $params, string $request, Route &$route)
    {
        foreach ($params as $key => $regex) {
            preg_match(sprintf('#%s#', $regex), $request, $result);
            $route->addParam($key, $result[0]);
            $route->setPath(strtr($route->getPath(), [sprintf('{%s}', $key) => $result[0]]));
        }
    }

    private function loadRoutes()
    {
        $routes = require_once __DIR__ . '/../config/route.php';

        foreach ($routes as $route) {
            $this->routes[] = new Route($route['path'], $route['controller'], $route['params'] ?? []);
        }
    }
}