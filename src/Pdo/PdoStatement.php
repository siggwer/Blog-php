<?php

namespace App\Pdo;

use PDOStatement as PDOState;
use App\Pdo\Interfaces\PdoStatementInterface;
class PdoStatement implements PdoStatementInterface
{
    /**
     * @var PdoStatement $statement
     */
    private $statement;

    /**
     * PdoStatement constructor.
     *
     * @param PDOState $statement
     */
    public function __construct(PDOState $statement)
    {
        $this->statement = $statement;
    }

    /**
     * @param $parameter
     * @param $value
     * @param $data_type
     */
    public function bindValue($parameter, $value, $data_type)
    {
        $this->statement->bindValue($parameter, $value, $data_type);
    }

    /**
     * @param null $input_parameters
     */
    public function execute($input_parameters = null)
    {
        $this->statement->execute($input_parameters);
    }

    /**
     * @return mixed|null
     */
    public function fetch()
    {
        if ($this->statement) {
            return $this->statement->fetch();
        }
        return null;
    }

    /**
     * @return mixed|null
     */
    public function fetchAll()
    {
        if ($this->statement) {
            return $this->statement->fetchAll();
        }
        return null;
    }

}
