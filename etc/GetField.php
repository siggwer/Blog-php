<?php

namespace Framework;


trait GetField
{
    /**
     * @param $field
     *
     * @return mixed
     */
    protected function getField($field)
    {
        //var_dump($_POST);
        //die;
        return filter_var($_POST[$field] ?? null, FILTER_SANITIZE_STRING);
    }

    /**
     * @param $session
     *
     * @return null
     */
    protected function  getSession($session)
    {
        return $_SESSION[$session] ?? null;
    }

    /**
     * @param $files
     *
     * @return null
     */
    protected function getFiles($files)
    {
        return $_FILES[$files] ?? null;
    }
}