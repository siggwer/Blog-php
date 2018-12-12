<?php

namespace App\Model;


use App\Repository\Interfaces\CommentRepositoryInterface;

class Comment
{
    /**
     * @var CommentRepositoryInterface $comment
     */
    private $comment;

    /**
     * @param CommentRepositoryInterface $comment
     */
    public function _construct(CommentRepositoryInterface $comment){
        $this->comment = $comment;
    }

    /**
     * @param int $articleId
     * @return array
     */
    public function getCommentId(int $articleId): array
    {
        $comment = $this->comment->getCommentById($articleId);
        return $comment;
    }

    /**
     * @param int $id
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
     * @return array
     */
    public function insertComment($comment): array
    {
        $comment = $this->comment->insertComment($comment);
        return $comment;
    }

    /**
     * @param $comment
     * @return mixed
     */
    public function updateComment($comment)
    {
        $comment = $this->comment->updateComment($comment);
        return $comment;
    }

}