<?php

namespace App\Repository;

use DateTime;
class Users
{
    /**
     * @var
     */
    private $id,
        $password,
        $email,
        $email_token,
        $rank,
        $connection_at,
        $register_at;

    /**
     * Users constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        if (!empty($data))
        {
            $this->hydrate($data);
        }
    }

    /**
     * @param array $data
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (is_callable([$this, $method]))
            {
                $this->$method($value);
            }
        }
    }

    // SETTERS //

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @param $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param $email_token
     */
    public function setEmail_token($email_token)
    {
        $this->email_token = $email_token;
    }

    /**
     * @param $connection_at
     */
    public function setConnection_at($connection_at)
    {
        $this->connection_at = $this->setDateTime($connection_at);
    }

    /**
     * @param $register_at
     */
    public function setRegister_at($register_at)
    {
        $this->register_at = $this->setDateTime($register_at);
    }

    // GETTERS //

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function rank()
    {
        return $this->rank;
    }

    /**
     * @return mixed
     */
    public function password()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function email_token()
    {
        return $this->email_token;
    }

    /**
     * @return mixed
     */
    public function connection_at()
    {
        return $this->connection_at;
    }

    /**
     * @return mixed
     */
    public function register_at()
    {
        return $this->register_at;
    }

    /**
     * @param $value
     * @return bool|DateTime
     */
    protected function setDateTime($value)
    {
        if (is_string($value)) {
            return DateTime::createFromFormat('Y-m-d H:i:s', $value);
        }
        return $value;
    }
}