<?php


namespace Framework\Interfaces;


interface RouterInterface
{
    /**
     * RouterInterface constructor.
     */
    public function __construct();

    /**
     * @param  array $request
     * @return mixed
     */
    public function handleRequest(array $request = []);

}
