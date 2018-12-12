<?php

namespace App\Model;


use App\Repository\Interfaces\ArticleRepositoryInterface;
use App\Pdo\Interfaces\PdoStatementInterface;

class ArticleDetail
{
    /**
     * @var $articleDetail
     */
    private $articleDetail;

    /**
     * @param ArticleRepositoryInterface $articleDetail
     */
    public function _construct(ArticleRepositoryInterface $articleDetail){
        $this->articleDetail = $articleDetail;

    }

    /**
     * @param int $articleId
     * @return mixed
     */
    public function getArticleWithId(int $articleId)
    {
        $article = $this->articleDetail->getByArticleId($articleId);
        return  $article;
    }

    /**
     * @param $articleId
     * @return PdoStatementInterface
     */
    public function updatePost($articleId): PdoStatementInterface
    {
        $article = $this->articleDetail->updatePost($articleId);
        return $article;
    }

    /**
     * @param $articleId
     * @return array
     */
    public function insertPost($articleId): array
    {
        $article = $this->articleDetail->insertPost($articleId);
        return $article;
    }

    /**
     * @param int $articleId
     * @return mixed
     */
    public function deletePost(int $articleId){
        $article = $this->articleDetail->deletePost($articleId);
        return  $article;
    }

}