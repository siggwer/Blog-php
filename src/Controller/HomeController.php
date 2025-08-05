<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Articles;
use DI\Container;
use Framework\Interfaces\RenderInterfaces;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{
    public function __construct(private Articles $articles)
    {
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        Container $container
    ): ResponseInterface {
        $articles = $this->articles->home();
        $view = $container->get(RenderInterfaces::class)->render(
            'home',
            ['articles' => $articles]
        );
        $response->getBody()->write($view);

        return $response;
    }
}
