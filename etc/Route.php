<?php

declare(strict_types=1);

namespace Framework;

use Framework\Interfaces\RouteInterface;

class Route implements RouteInterface
{
    /**
     * @var
     */
    private $path;

    /**
     * @var
     */
    private $controller;

    /**
     * @var array
     */
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

    /**
     * @param $key
     * @param $value
     */
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
