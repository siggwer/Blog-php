<?php

namespace App\Repository\Interfaces;

use App\Pdo\Interfaces\PdoStatementInterface;
interface HomeRepositoryInterface
{
    /**
     * @return array
     */
    public function all(): array;
}