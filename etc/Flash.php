<?php

namespace Framework;

trait Flash
{
    /**
     * @param $type
     * @param $content
     */
    protected function setFlash($type, $content)
    {
        $_SESSION['flash'] = compact('type', 'content');
    }
}
