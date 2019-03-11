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
    private $publicationDate;

    /**
     * @var
     */
    private $updateDate;

    /**
     * @var
     */
    private $authorId;

    /**
     * @var
     */
    private $updateBy;

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
     * @param $publicationDate
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $this->setDateTime($publicationDate);
    }

    /**
     * @param $updateDate
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $this->setDateTime($updateDate);
    }

    /**
     * @param $authorId
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = (int) $authorId;
    }

    /**
     * @param $updateBy
     */
    public function setUpdateBy($updateBy)
    {
        $this->updateBy = (int) $updateBy;
    }

    //GETTERS

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @return mixed
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @return mixed
     */
    public function updateBy()
    {
        return $this->updateBy;
    }
}