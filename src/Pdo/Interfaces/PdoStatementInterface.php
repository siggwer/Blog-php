<?php

namespace App\Pdo\Interfaces;


interface PdoStatementInterface
{
    /**
     * PdoStatementInterface constructor.
     * @param PDOState $statement
     */
    public function __construct(PDOState $statement);

    /**
     * @param $parameter
     * @param $value
     * @param $data_type
     * @return mixed
     */
    public function bindValue($parameter, $value, $data_type);

    /**
     * @param null $input_parameters
     * @return mixed
     */
    public function execute($input_parameters = null);

    /**
     * @return mixed
     */
    public function fetch();


}