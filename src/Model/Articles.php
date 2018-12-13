<?php

namespace App\Model;


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
    public function __construct(ArticleRepositoryInterface $articles){
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
     * @param int $articleId
     * @return mixed
     */
    public function getArticleWithId(int $articleId)
    {
        $article = $this->articles->getByArticleId($articleId);
        return  $article;
    }

    /**
     * @param $articleId
     * @return PdoStatementInterface
     */
    public function updatePost($articleId): PdoStatementInterface
    {
        $article = $this->articles->updatePost($articleId);
        return $article;
    }

    /**
     * @param $articleId
     * @return array
     */
    public function insertPost($articleId): array
    {
        $article = $this->articles->insertPost($articleId);
        return $article;
    }

    /**
     * @param int $articleId
     * @return mixed
     */
    public function deletePost(int $articleId){
        $article = $this->articles->deletePost($articleId);
        return  $article;
    }

}