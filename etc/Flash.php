<?php

namespace Framework;

trait Flash
{
    protected function setFlash($type, $content)
    {
        $_SESSION['flash'] = compact('type', 'content');
    }
}
