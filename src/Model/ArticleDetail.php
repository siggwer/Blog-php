<?php

namespace App\Model;


use App\Repository\ArticleRepository;
use Romss\Database\StatementInterface;

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

    public function getArticleWithId(int $id)
    {
        $post = $this->articleDetail->getByArticleId($id);
        return $post;
    }

}