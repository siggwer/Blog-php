<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Home;
use DI\Container;
use Framework\Interfaces\RenderInterfaces;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
class HomeController
{
    private $articles;
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
     * HomeController constructor.
     * @param Home $articles
     */
    public function __construct(Home $articles) {
        $this->articles = $articles;
    }

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
        $articles = $this->articles->home();
        $view = $container->get(RenderInterfaces::class)->render('home', ['articles' => $articles]);
        $response->getBody()->write($view);
        return $response;
    }
}