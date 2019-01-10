<?php

namespace App\Controller;

use App\Service\Users;
use DI\Container;
use Framework\Interfaces\RenderInterfaces;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdministrationAccount
{
    /**
     * @var
     */
    private $articles;

    /**
     * AdministrationAccount constructor.
     *
     * @param Users$articles
     */
    public function __construct(Users $articles) {
        $this->articles = $articles;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param Container $container
     *
     * @return ResponseInterface
     *
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Container $container) {
        $articles = $this->articles->allArticlesByPseudo($request->getAttribute('pseudo', 0));
        $view = $container->get(RenderInterfaces::class)->render('administration', ['articles' => $articles]);
        $response->getBody()->write($view);
        return $response;
    }
}