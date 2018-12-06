<?php

namespace Framework;


trait Token
{
    /**
     * @return string
     */
    protected function generateToken()
    {
        return hash('sha512', uniqid().'---'.time());
    }
}