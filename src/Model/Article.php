<?php

namespace App\Model;

class Article extends AbstractModel
{
    /**
     * @var
     */
    private $title;

    /**
     * @var
     */
    private $chapo;

    /**
     * @var
     */
    private $content;

    /**
     * @var
     */
    private $publication_date;

    /**
     * @var
     */
    private $update_date;

    /**
     * @var
     */
    private $author_id;

    //SETTERS

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param $chapo
     */
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param $publication_date
     */
    public function setPublication_date($publication_date)
    {
        $this->publication_date = $this->setDateTime($publication_date);
    }

    /**
     * @param $update_date
     */
    public function setUpdate_date($update_date)
    {
        $this->update_date = $this->setDateTime($update_date);
    }

    /**
     * @param $author_id
     */
    public function setAuthor_id($author_id)
    {
        $this->author_id = (int) $author_id;
    }

    //GETTERS

    /**
     * @return mixed
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function chapo()
    {
        return $this->chapo;
    }

    /**
     * @return mixed
     */
    public function content()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function publication_date()
    {
        return $this->publication_date;
    }

    /**
     * @return mixed
     */
    public function update_date()
    {
        return $this->update_date;
    }

    /**
     * @return mixed
     */
    public function author_id()
    {
        return $this->author_id;
    }
}