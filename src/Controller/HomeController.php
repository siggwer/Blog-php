<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ArticleRepository;
use DI\Container;
use Framework\Interfaces\RenderInterfaces;
use DI\DependencyException;
use DI\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class HomeController
{

    //private $articles;
    //private $render;
    //private $container;

    //public function __construct() {
        //$this->articles = new ArticleRepository();
        //$this->render = new Render();

    //}

    //public function __construct(Container $container) {
        //$this->articles = new ArticleRepository();
        //$this->container = $container;
    //}

    //public function __invoke()
    //{
        //$articles = $this->articles->getArticles();
        //$this->render->render('home', ['articles' => $articles]);
        //echo $this->render->render('home.html.twig', ['articles' => $articles]);
        //echo $this->container->get(Render::class)->render('home.html.twig', ['articles' => $articles]);
        //$this->getConteneur()['article_repository'];
        //$this->getConteneur()->get('article_repository');
    //}

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param Container $container
     * @return ResponseInterface
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Container $container)
    {
        $view = $container->get(RenderInterface::class)->render('home');
        $response->getBody()->write($view);
        return $response;
    }
}