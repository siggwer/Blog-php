<?php

namespace App\Model;

use DateTime;
class User
{
    /**
     * @var $id $pseudo $password $email $email_token $rank $connexion_at $register_at
     */
    private $id;
    private $pseudo;
    private $password;
    private $email;
    private $email_token;
    private $rank;
    private $connexion_at;
    private $register_at;

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
     * @param $pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
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
    public function setConnexion_at($connexion_at)
    {
        $this->connection_at = $this->setDateTime($connexion_at);
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
    public function pseudo()
    {
        return $this->pseudo;
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
    public function connexion_at()
    {
        return $this->connexion_at;
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