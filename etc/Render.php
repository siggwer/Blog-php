<?php


namespace Framework;


use Framework\Interfaces\RenderInterfaces;

class Render implements RenderInterfaces
{
    private $twig;
    private $loader;


    public function __construct()
    {
        $this->loader = new \Twig_Loader_Filesystem('../templates/');
        $this->twig = new \Twig_Environment($this->loader, []);
    }

    /**
     * @param string $namespace
     * @param null|string $path
     * @throws \Twig_Error_Loader
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

    /**
     * @param string $key
     * @param $value
     */
    public function addGlobal(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render(string $view, array $params = null)
    {
        return $this->twig->render($view, $params);
    }
}