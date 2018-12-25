<?php

namespace App\Model;

use DateTime;
class Comment
{
    /**
     * @var $id, $comments, $author, $comment_date, $validated, $article_id
     */
    private $id;
    private $comments;
    private $author;
    private $comment_date;
    private $validated;
    private $article_id;

    /**
     * Comment constructor.
     * @param array $data
     */
    public function __construct($data =[])
    {
        if(!empty($data))
        {
            $this->hydrate($data);
        }
    }

    /**
     * @param array $data
     */
    public function hydrate(array $data)
    {
        foreach($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (is_callable([$this, $method]))
            {
                $this->$method($value);
            }
        }
    }

    //SETTERS

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

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
    public function id()
    {
        return $this->id;
    }

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

    /**
     * @param $value
     * @return bool|DateTime
     */
    protected function setDateTime($value)
    {
        if (is_string($value)) {
            return DateTime::createFromFormat('Y-m-d H:i:s', $value);
        }
        return $value;
    }
}