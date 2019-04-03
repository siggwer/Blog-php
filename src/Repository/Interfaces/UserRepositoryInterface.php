<?php


namespace App\Repository\Interfaces;

use App\Pdo\Interfaces\PdoStatementInterface;
use App\Model\User;
use App\Service\Users;

interface UserRepositoryInterface
{
    /**
     * @param $user
     *
     * @return User
     */
    public function registerUser(User $user): User;

    /**
     * @param User $user
     *
     * @return PdoStatementInterface
     */
    public function updateUser(User $user): PdoStatementInterface;

    /**
     * @param $email
     *
     * @return User
     */
    public function getUserByEmail($email): User;

    /**
     * @param $pseudo
     *
     * @return User
     */
    public function getUserByPseudo($pseudo): User;

    /**
     * @param int $userId
     *
     * @return mixed
     */
    public function getUserById(int $userId);

    /**
     * @param User $rankAdmin
     *
     * @return mixed
     */
    public function getRank(User $rankAdmin);

    /**
     * @return mixed
     */
    public function allusers();

    /**
     * @param $pseudo
     *
     * @return Users
     */
    public function allArticlesByPseudo($pseudo): User;
}
