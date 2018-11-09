<?php


namespace Framework\Interfaces;


interface RequestInterface
{
    public function __construct($query = [], $post = [], $file = [], $session = [], $server = []);

    public static function createFromGlobals();
}