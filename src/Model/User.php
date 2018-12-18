<?php

namespace App\Model;

use App\Repository\Interfaces\UserRepositoryInterface;
use App\Pdo\Interfaces\PdoStatementInterface;
class User
{
    /**
     * @var $user
     */
    private $user;

    /**
     * User constructor.
     * @param UserRepositoryInterface $user
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @param $email
     * @return mixed
     */
    public function getUserByEmail($email)
    {
        $userEmail = $this->user->getUserByEmail($email);
        return $userEmail;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getUserById($userId)
    {
        $idUser = $this->user->getUserById($userId);
        return $idUser;
    }

    /**
     * @param $user
     * @return mixed
     */
    public function registerUser($user)
    {
        $user = $this->user->registerUser($user);
        return $user;
    }

    public function updateUser($user): PdoStatementInterface
    {
        $user = $this->user->updateUser($user);
        return $user;
    }

    /**
     * @return mixed
     */
    public function  allusers(){
        $users = $this->user->allusers();
        return $users;
    }

    /**
     * @param $rankAdmin
     * @return mixed
     */
    public function getRank($rankAdmin){
        var_dump($rankAdmin);
        $users = $this->user->getRank($rankAdmin);
        return $users;
        var_dump($users);
    }
}