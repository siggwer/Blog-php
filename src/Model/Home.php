<?php

namespace App\Model;

use App\Repository\Interfaces\ArticleRepositoryInterface;
//use App\Pdo\Interfaces\PdoStatementInterface;
class Home
{
    /**
     * @var ArticleRepositoryInterface
     */
    private $articles;

    /**
     * Home constructor.
     * @param ArticleRepositoryInterface $articles
     */
    public function __construct(ArticleRepositoryInterface $articles)
    {
        $this->articles = $articles;
    }

    /**
     * @return array
     */
    public function home(): array
    {
        $allpost = $this->articles->all();
        return $allpost;
    }

}