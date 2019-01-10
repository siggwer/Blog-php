<?php

namespace App\Service;

//use App\Model\User;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Pdo\Interfaces\PdoStatementInterface;

class Users
{
    /**
     * @var $user
     */
    private $user;

    /**
     * Users constructor.
     *
     * @param UserRepositoryInterface $user
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    public function getUserByEmail($email)
    {
        $userEmail = $this->user->getUserByEmail($email);
        return $userEmail;
    }

    /**
     * @param $pseudo
     *
     * @return mixed
     */
    public function getUserByPseudo($pseudo)
    {
        $userPseudo = $this->user->getUserByPseudo($pseudo);
        return $userPseudo;
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    public function getUserById($userId)
    {
        $idUser = $this->user->getUserById($userId);
        return $idUser;
    }

    /**
     * @param $user
     *
     * @return mixed
     */
    public function registerUser($user)
    {
        $user = $this->user->registerUser($user);
        return $user;
    }

    /**
     * @param $user
     *
     * @return PdoStatementInterface
     */
    public function updateUser($user): PdoStatementInterface
    {
        $user = $this->user->updateUser($user);
        return $user;
    }

    /**
     * @return mixed
     */
    public function  allusers()
    {
        $users = $this->user->allusers();
        return $users;
    }

    /**
     * @param $pseudo
     *
     * @return Users
     */
    public function allArticlesByPseudo($pseudo)
    {
        $users = $this->user->allArticlesByPseudo($pseudo);
        return $users;
    }

    /**
     * @param $rankAdmin
     *
     * @return mixed
     */
    public function getRank($rankAdmin){
        $users = $this->user->getRank($rankAdmin);
        return $users;
    }
}