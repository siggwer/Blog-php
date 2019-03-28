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
     * @param int $id
     *
     * @return mixed
     */
    public function getComment(int $id);

    /**
     * @param int $id
     *
     * @return array
     */
    public function getCommentById(int $id): array;

    /**
     * @param $comment
     *
     * @return array
     */
    public function insertComment($comment): array;

    /**
     * @param $comment
     *
     * @return mixed
     */
    public function updateComment($comment): PdoStatementInterface;

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function getCommentForvalidated(int $id);

    /**
     * @param $comment
     *
     * @return PdoStatementInterface
     */
    public function validatedComment($comment): PdoStatementInterface;

    /**
     * @param $comment
     *
     * @return array
     */
    public function deleteComment($comment);
}
