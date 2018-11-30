<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ArticleRepository;
use DI\Container;
use Framework\Render;

class HomeController
{

    private $articles;
    private $render;
    //private $container;

    public function __construct() {
        $this->articles = new ArticleRepository();
        $this->render = new Render();

    }

    //public function __construct(Container $container) {
        //$this->articles = new ArticleRepository();
        //$this->contianer = $container;
    //}

    public function __invoke()
    {
        $articles = $this->articles->getArticles();
        //$this->render->render('home', ['articles' => $articles]);
        echo $this->render->render('home.twig', ['articles' => $articles]);
        //echo $this->container->get(Render::class)->render('home.twig', ['articles' => $articles]);
        //$this->getConteneur()['article_repository'];
        //$this->getConteneur()->get('article_repository');
    }
}