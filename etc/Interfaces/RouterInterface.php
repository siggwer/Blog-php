<?php


namespace Framework\Interfaces;


interface RouterInterface
{
    public function __construct();

    public function handleRequest(array $request = []);

}