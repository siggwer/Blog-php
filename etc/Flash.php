<?php


namespace Framework;


trait Flash
{
    protected function setFlash($type, $content) {
        $session['flash'] = compact('type', 'content' );
    }
}