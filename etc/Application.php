<?php


namespace Framework;

use DI\Container;
use DI\ContainerBuilder;
class Application
{
    /**
     * @var Container @container
     */
    private $container;

    /**
     * @throws \Exception
     */
    public function init()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);
        $containerBuilder->addDefinitions(__DIR__.'/../configs/dic/database.php');
        $containerBuilder->addDefinitions(__DIR__.'/../configs/dic/repositories.php');
        $containerBuilder->addDefinitions(__DIR__.'/../configs/dic/render.php');
        $containerBuilder->addDefinitions(__DIR__. '/../configs/dic/SwiftMailer.php');
        $this->container = $containerBuilder->build();
        $this->initRouter();
    }

}