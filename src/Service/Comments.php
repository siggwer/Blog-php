<?php

namespace App\Service;

use App\Repository\Interfaces\CommentRepositoryInterface;

class Comments
{
    /**
     * @var CommentRepositoryInterface $comment
     */
    private $comment;

    /**
     * @param CommentRepositoryInterface $comment
     */
    public function __construct(CommentRepositoryInterface $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getCommentId(int $id): array
    {
        $comment = $this->comment->getCommentById($id);
        return $comment;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function getComment(int $id)
    {
        $commentId = $this->comment->getComment($id);
        return $commentId;
    }

    /**
     * @return array
     */
    public function allComments(): array
    {
        $allComments = $this->comment->all();
        return $allComments;
    }

    /**
     * @param $comment
     *
     * @return array
     */
    public function insertComment($comment): array
    {
        $comment = $this->comment->insertComment($comment);
        return $comment;
    }

    /**
     * @param $comment
     *
     * @return \App\Pdo\Interfaces\PdoStatementInterface|mixed
     */
    public function updateComment($comment)
    {
        $comment = $this->comment->updateComment($comment);
        return $comment;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function getCommentForvalidated(int $id)
    {
        $comment = $this->comment->getCommentForvalidated($id);
        return $comment;
    }

    /**
     * @param int $id
     *
     * @return \App\Pdo\Interfaces\PdoStatementInterface
     */
    public function validatedComment(int $id)
    {
        $comment = $this->comment->validatedComment($id);
        return $comment;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function deleteComment(int $id)
    {
        $comment = $this->comment->deleteComment($id);
        return $comment;
    }
}
