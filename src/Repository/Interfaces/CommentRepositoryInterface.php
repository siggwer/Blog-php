<?php

namespace App\Repository\Interfaces;

use App\Pdo\Interfaces\PdoStatementInterface;
interface CommentRepositoryInterface
{
    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param int $articleId
     * @return mixed
     */
    public function getComment(int $articleId);

    /**
     * @param int $articleId
     * @return array
     */
    public function getCommentById(int $articleId):array;

    /**
     * @return array
     */
    public function allComments(): array;

    /**
     * @param $comment
     * @return array
     */
    public function insertComment($comment): array;

    /**
     * @param $comment
     * @return mixed
     */
    public function updateComment($comment): PdoStatementInterface;
}