<?php

namespace App\Model;

use DateTime;
class Article
{
    /**
     * @var $id, $title, $chapo, $content, $publication_date, $update_date, $author_id
     */
    private $id;
    private $title;
    private $chapo;
    private $content;
    private $publication_date;
    private $update_date;
    private $author_id;

    /**
     * Article constructor.
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
    public function id()
    {
        return $this->id;
    }

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