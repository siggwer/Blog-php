<?php
namespace Framework\Interfaces;


interface ApplicationInterface
{
    /**
     * @return mixed
     */
    public function init();

    /**
     * ApplicationInterface constructor.
     */
    public function __construct();

    /**
     * @param array $request
     * @return mixed
     */
    public function handleRequest(array $request = []);
}