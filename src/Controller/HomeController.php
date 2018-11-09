<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ArticleRepository;
use Framework\View;

class HomeController
{

    private $articles;
    private $view;

    public function __construct() {
        $this->articles = new ArticleRepository();
        $this->view = new View();
    }

    public function __invoke()
    {
        echo 'Coucou from HomeController';
        $articles = $this->articles->getArticles();
        $this->view->renderFile('home', ['articles' => $articles]);
    }
}