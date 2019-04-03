<?php

// Render configuration

use function \DI\get as di_get;
use function \DI\object as di_object;
use function \DI\string as di_string;

use Framework\Interfaces\RenderInterfaces;
use Framework\Render;

return [
    'twig.path' => di_string(__DIR__.'/../templates'),
     RenderInterfaces::class => di_object(Render::class)
     ->constructor(di_get('twig.path'))
];
