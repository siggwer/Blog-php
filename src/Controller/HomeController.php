<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ArticleRepository;
use Framework\Render;

class HomeController
{

    private $articles;
    private $render;

    public function __construct() {
        $this->articles = new ArticleRepository();
        $this->render = new Render();
    }

    public function __invoke()
    {
        $articles = $this->articles->getArticles();
        //$this->render->render('home', ['articles' => $articles]);
        echo $this->render->render('home.twig', ['articles' => $articles]);
        //$this->getConteneur()['article_repository'];
        //$this->getConteneur()->get('article_repository');
    }
}