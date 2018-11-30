<?php
namespace Framework\Interfaces;


interface ApplicationInterface
{
    /**
     * @return mixed
     */
    public function init();

    /**
     * @param array $request
     * @return mixed
     */
    public function handleRequest(array $request = []);
}