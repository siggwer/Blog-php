<?php
namespace Framework\Interfaces;


interface ApplicationInterface
{
    /**
     * @return mixed
     */
    public function init();

    /**
     * @return mixed
     */
    public function handleRequest();


}