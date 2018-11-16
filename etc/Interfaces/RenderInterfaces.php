<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/11/2018
 * Time: 15:57
 */

namespace Framework\Interfaces;


interface RenderInterfaces
{
    public function __construct();

    public function addPath(string $namespace, ?string $path = null): void;

    public function addGlobal(string $key, $value): void;

    public function render(string $view, array $params = null);
}