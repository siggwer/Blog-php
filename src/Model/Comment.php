<?php

namespace App\Model;

use DateTime;
class Comment extends AbstractModel
{
    /**
     * @var $id, $comments, $author, $comment_date, $validated, $article_id
     */
    private $comments;
    private $author;
    private $comment_date;
    private $validated;
    private $article_id;

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
     * @param $comment_date
     */
    public function setComment_date($comment_date)
    {
        $this->comment_date = $this->setDateTime($comment_date);
    }

    /**
     * @param $validated
     */
    public function setValidated($validated)
    {
        $this->validated = (int) $validated;
    }

    public function setArticle_id($article_id)
    {
        $this->article_id = (int) $article_id;
    }

    //GETTERS

    /**
     * @return mixed
     */
    public function comments()
    {
        return $this->comments;
    }

    /**
     * @return mixed
     */
    public function author()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function comment_date()
    {
        return $this->comment_date;
    }

    /**
     * @return mixed
     */
    public function validated()
    {
        return $this->validated;
    }

    /**
     * @return mixed
     */
    public function article_id()
    {
        return $this->article_id;
    }
}