<?php

namespace Framework;

use PDO;
use Exception;

abstract class Connexion
{
    // PDO object to access the DB
    private $connection;

    private function checkConnection()
    {
        if (\is_null($this->connection)) {
            return $this->getConnection();
        }
        return $this->connection;
    }

    private function getConnection()
    {
        try {
            $config = include __DIR__ . '/../config/db.php';
            $this->connection = new PDO(
                $config['host'],
                $config['username'],
                $config['password']
            );
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
            return $this->connection;
        } catch (Exception $errorConnection) {
            $_SESSION['message'] = sprintf(
                'Erreur de connection : %s',
                $errorConnection->getMessage()
            );
        }
    }

    protected function sql($sql, $parameters = null)
    {
        if (!\is_null($parameters)) {
            $result = $this->checkConnection()->prepare($sql);
            $result->execute($parameters);
            return $result;
        }

        return $this->checkConnection()->query($sql);
    }
}
