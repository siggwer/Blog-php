<?php

namespace App\Pdo\Interfaces;


/**
 * Interface PdoStatementInterface
 *
 * @package App\Pdo\Interfaces
 */
interface PdoStatementInterface
{
    /**
     * @param $parameter
     * @param $value
     * @param $data_type
     *
     * @return mixed
     */
    public function bindValue($parameter, $value, $data_type);

    /**
     * @param null $input_parameters
     *
     * @return mixed
     */
    public function execute($input_parameters = null);

    /**
     * @return mixed
     */
    public function fetch();

    /**
     * @return mixed
     */
    public function fetchAll();

}
