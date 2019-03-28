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
     *
     * @return mixed
     */
    public function getByArticleId(int $id);

    /**
     * @param string $pseudo
     *
     * @return mixed
     */
    public function getByArticlePseudo(string $pseudo);

    /**
     * @param $id
     *
     * @return array
     */
    public function insertArticle($id): array;

    /**
     * @param $articles
     *
     * @return PdoStatementInterface
     */
    public function updateArticle($articles): PdoStatementInterface;

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function deleteArticle(int $id);

}
