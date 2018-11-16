<?php

declare(strict_types=1);

namespace Framework;


class UrlGeneration
{
    /**
     * @var array
     */
    private $routes = [];

    public function __construct()
    {
        $this->loadRoutes();
    }

    public function generate($routeName, array $params = [])
    {

        foreach ($this->routes as $key => $route) {
            if ($routeName === $key && \count($params) == 0) {
                return $route['path'];
            }

            if ($routeName === $key && \count($params) > 0) {
                return $this->addParams($params, $route['path'], $route['params']);
            }
        }
    }

    /**
     * @inheritdoc
     */
    private function loadRoutes()
    {
        $this->routes = include __DIR__ .'/../config/routes.php';
    }

    private function addParams($params, $path)
    {
        foreach ($params as $key => $param) {
            return implode([strtr($path, [sprintf('{%s}', $key) => $param])]);
        }
    }
}