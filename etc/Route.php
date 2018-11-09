<?php

declare(strict_types=1);

namespace Framework;

use Framework\Interfaces\RouteInterface;

class Route
{
    private $path;

    private $controller;

    private $params = [];

    /**
     * @inheritdoc
     */
    public function __construct($path, $controller, array $params = [])
    {
        $this->path = $path;
        $this->controller = $controller;
        $this->params = $params;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    public function addParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}