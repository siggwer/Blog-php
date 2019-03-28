<?php

namespace App\Pdo;

use DateTime;
use PDO;
use App\Pdo\Interfaces\PdoDatabaseInterface;
use App\Pdo\Interfaces\PdoStatementInterface;
class PdoDatabase extends PDO implements PdoDatabaseInterface
{
    const TYPE_FIELD = [
        'integer' => parent::PARAM_INT,
        'boolean' => parent::PARAM_BOOL,
    ];

    /**
     * PdoDatabase constructor.
     *
     * @param string $dsn
     * @param string $username
     * @param string $passwd
     * @param array  $options
     */
    public function __construct(string $dsn, string $username = '', string $passwd = '', array $options = [])
    {
        parent::__construct($dsn, $username, $passwd, $options);
        parent::setAttribute(parent::ATTR_DEFAULT_FETCH_MODE, parent::FETCH_ASSOC);
        parent::setAttribute(parent::ATTR_ERRMODE, parent::ERRMODE_EXCEPTION);
        parent::setAttribute(parent::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * @param  string $statement
     * @param  array  $params
     * @return PdoStatementInterface
     */
    public function request(string $statement, array $params = []): PdoStatementInterface
    {
        $statement = new PdoStatement($this->prepare($statement));

        foreach ($params as $name => $param) {
            $paramType = gettype($param);
            $bindType = parent::PARAM_STR;

            if ($param instanceof DateTime) {
                $param = $param->format('Y-m-d H:i:s');
            } elseif (array_key_exists($paramType, self::TYPE_FIELD)) {
                $bindType = self::TYPE_FIELD[$paramType];
            } elseif ($param === null) {
                $bindType = parent::PARAM_NULL;
            }

            $statement->bindValue($name, $param, $bindType);
        }

        $statement->execute();
        return $statement;
    }

    /**
     * Return last inserted Id
     *
     * @return int
     */
    public function lastId(): int
    {
        return parent::lastInsertId();
    }
}
