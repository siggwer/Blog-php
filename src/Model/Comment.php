<?php

namespace App\Model;

class Comment extends AbstractModel
{

    /**
     * @var
     */
    private $comments;

    /**
     * @var
     */
    private $author;

    /**
     * @var
     */
    private $commentDate;

    /**
     * @var
     */
    private $validated;

    /**
     * @var
     */
    private $articleId;

    //SETTERS

    /**
     * @param $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @param $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @param $commentDate
     */
    public function setCommentDate($commentDate)
    {
        $this->commentDate = $this->setDateTime($commentDate);
    }

    /**
     * @param $validated
     */
    public function setValidated($validated)
    {
        $this->validated = (int) $validated;
    }

    /**
     * @param $articleId
     */
    public function setArticleId($articleId)
    {
        $this->articleId = (int) $articleId;
    }

    //GETTERS

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getCommentDate()
    {
        return $this->commentDate;
    }

    /**
     * @return mixed
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * @return mixed
     */
    public function getArticleId()
    {
        return $this->articleId;
    }
}
