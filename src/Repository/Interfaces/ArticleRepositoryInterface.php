<?php

namespace App\Repository\Interfaces;

use App\Pdo\Interfaces\PdoStatementInterface;
interface ArticleRepositoryInterface
{
    /**
     * @return array
     */
    public function all(): array;
}