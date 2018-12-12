<?php

namespace App\Repository\Interfaces;

use App\Pdo\Interfaces\PdoStatementInterface;
interface ArticleRepositoryInterface
{
    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param int $articleId
     * @return mixed
     */
    public function getByArticleId(int $articleId);

    /**
     * @param $articleId
     * @return array
     */
    public function insertPost($articleId): array;

    /**
     * @param $articleId
     * @return PdoStatementInterface
     */
    public function updatePost($articleId): PdoStatementInterface;

    /**
     * @param int $articleId
     * @return mixed
     */
    public function deletePost(int $articleId);

}