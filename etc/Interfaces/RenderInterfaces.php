<?php

namespace Framework\Interfaces;


interface RenderInterfaces
{
    /**
     * RenderInterfaces constructor.
     * @param string $path
     */
    public function __construct(string $path);

    /**
     * @param string $namespace
     * @param null|string $path
     */

    public function addPath(string $namespace, ?string $path = null): void;

    /**
     * @param string $key
     * @param $value
     */
    public function addGlobal(string $key, $value): void;

    /**
     * @param string $view
     * @param array|null $params
     * @param string $type
     * @return mixed
     */
    public function render(string $view, array $params = null, $type = 'html');
}