<?php

namespace Framework\Interfaces;

interface RouteInterface
{
    public function __construct($path, $controller, array $params = []);

    public function setPath($path);

    public function getPath();

    public function getController();

    public function getParams();
}
