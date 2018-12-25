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
     * @param int $id
     * @return mixed
     */
    public function getArticleWithId(int $id)
    {
        $article = $this->articles->getByArticleId($id);
        return  $article;
    }

    /**
     * @param $id
     * @return PdoStatementInterface
     */
    public function updatePost($id): PdoStatementInterface
    {
        $article = $this->articles->updatePost($id);
        return $article;
    }

    /**
     * @param $id
     * @return array
     */
    public function insertPost($id): array
    {
        $article = $this->articles->insertPost($id);
        return $article;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deletePost(int $id){
        $article = $this->articles->deletePost($id);
        return  $article;
    }

}