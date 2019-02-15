<?php

namespace App\Model;

class User extends AbstractModel
{
    /**
     * @var
     */
    private $pseudo;
    /**
     * @var
     */
    private $password;
    /**
     * @var
     */
    private $email;
    /**
     * @var
     */
    private $email_token;
    /**
     * @var
     */
    private $rank;
    /**
     * @var
     */
    private $connexion_at;
    /**
     * @var
     */
    private $register_at;

    // SETTERS //

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
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getEmail_token()
    {
        return $this->email_token;
    }

    /**
     * @return mixed
     */
    public function getConnexion_at()
    {
        return $this->connexion_at;
    }

    /**
     * @return mixed
     */
    public function getRegister_at()
    {
        return $this->register_at;
    }
}