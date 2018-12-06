<?php

namespace App\Model;

use App\Repository\Interfaces\HomeRepositoryInterface;
use App\Pdo\Interfaces\PdoStatementInterface;
class Home
{
    /**
     * @var HomeRepositoryInterface
     */
    private $articles;

    /**
     * Home constructor.
     * @param HomeRepositoryInterface $articles
     */
    public function __construct(HomeRepositoryInterface $articles)
    {
        $this->articles = $articles;
    }

    /**
     * @return array
     */
    public function home(): array
    {
        $allPost = $this->articles->all();
        return $allPost;
    }

}