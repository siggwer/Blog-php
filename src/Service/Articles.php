<?php

namespace App\Service;

use App\Repository\Interfaces\ArticleRepositoryInterface;
use App\Pdo\Interfaces\PdoStatementInterface;

class Articles
{
    /**
     * @var $articles
     */
    private $articles;

    /**
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
        $allPost = $this->articles->all();
        return $allPost;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function getArticleWithId(int $id)
    {
        $article = $this->articles->getByArticleId($id);
        return  $article;
    }

    public function getArticleWithPseudo(string $pseudo)
    {
        $article = $this->articles->getByArticlePseudo($pseudo);
        return  $article;
    }

    /**
     * @param $articles
     *
     * @return PdoStatementInterface
     */
    public function updateArticle($articles): PdoStatementInterface
    {
        $article = $this->articles->updateArticle($articles);
        return $article;
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function insertArticle($id): array
    {
        $article = $this->articles->insertArticle($id);
        return $article;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function deleteArticle(int $id)
    {
        $article = $this->articles->deleteArticle($id);
        return  $article;
    }
}
