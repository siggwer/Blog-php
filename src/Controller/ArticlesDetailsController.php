<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Framework\Render;

class ArticlesDetailsController
{
    /**
     * @var CommentRepository
     */
    private $articles;
    private $comments;
    private $render;

    /**
     * ArticlesDetailsController constructor.
     */
    public function __construct() {
        $this->articles = new ArticleRepository();
        $this->comments = new CommentRepository();
        $this->render = new Render();
    }

    /**
     * @param array $params
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(array $params = [])
    {
        $articles = $this->articles->getArticlesDetails($params['id']);
        $comments = $this->comments->getComment($params['id']);
        echo $this->render->render('articles.twig',['articles' => $articles,'comments' => $comments]);
    }

}