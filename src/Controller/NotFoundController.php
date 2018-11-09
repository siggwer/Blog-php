<?php

declare(strict_types=1);

namespace App\Controller;

class NotFoundController
{
    public function __invoke()
    {
        echo 'Cette page n\'exite pas';
    }
}