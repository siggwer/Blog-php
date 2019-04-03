<?php

namespace App\Pdo\Interfaces;

interface PdoDatabaseInterface
{
    /**
     * PdoDatabaseInterface constructor.
     *
     * @param string $dsn
     * @param string $username
     * @param string $passwd
     * @param array  $options
     */
    public function __construct(string $dsn, string $username = '', string $passwd = '', array $options = []);

    /**
     * @param  string $statement
     * @param  array  $params
     * @return PdoStatementInterface
     */
    public function request(string $statement, array $params = []): PdoStatementInterface;

    /**
     * @return int
     */
    public function lastId(): int;
}
