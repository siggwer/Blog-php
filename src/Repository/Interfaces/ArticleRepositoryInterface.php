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
     * @param int $id
     * @return mixed
     */
    public function getByArticleId(int $id);

    /**
     * @param $id
     * @return array
     */
    public function insertPost($id): array;

    /**
     * @param $id
     * @return PdoStatementInterface
     */
    public function updatePost($id): PdoStatementInterface;

    /**
     * @param int $id
     * @return mixed
     */
    public function deletePost(int $id);

}