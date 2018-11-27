<?php


namespace Framework;

use DI\Container;
class DependencyInjectionController
{
    /**
     * @var $container
     */
    private $container;

    /**
     * DependencyInjectionController constructor.
     */
    public function __construct() {
        $this->container = new Container;
    }
}