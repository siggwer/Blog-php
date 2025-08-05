<?php

namespace App\Repository;

use App\Pdo\Interfaces\PdoDatabaseInterface;
use App\Pdo\Interfaces\PdoStatementInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Model\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var PdoDatabaseInterface
     */
    private $database;

    /**
     * UserRepository constructor.
     *
     * @param PdoDatabaseInterface $database
     */
    public function __construct(PdoDatabaseInterface $database)
    {
        $this->database = $database;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function registerUser(User $user): User
    {
        $this->database->request(
            '
          INSERT INTO user (pseudo, password, email, email_token, register_at, connexion_at, rank) 
          VALUES (:pseudo, :password, :email, :emailToken, NOW(), NULL, 1)',
            [
                ':pseudo' => $user->getPseudo(),
                ':password' => $user->getPassword(),
                ':email' => $user->getEmail(),
                ':emailToken' => $user->getEmailToken()
            ]
        );
        $user->setId($this->database->lastId());
        return $user;
    }

    /**
     * @param User $user
     *
     * @return PdoStatementInterface
     */
    public function updateUser(User $user): PdoStatementInterface
    {
        return $this->database->request(
            'UPDATE user
        SET pseudo = :pseudo,
            email = :email,
            email_token = :emailToken,
            connexion_at = :connexionAt,
            rank = :rank
        WHERE id = :userId',
            [
                'pseudo' => $user->getPseudo(),
                ':email' => $user->getEmail(),
                ':emailToken' => $user->getEmailToken(),
                ':connexionAt' => $user->getConnexionat(),
                ':rank' => $user->getRank(),
                ':userId' => $user->getId()
            ]
        );
    }

    /**
     * @param $email
     *
     * @return User
     */
    public function getUserByEmail($email): User
    {
        return new User(
            $this->database->request(
                'SELECT id, pseudo, password, email, email_token, register_at, connexion_at, rank 
        FROM user
        WHERE email = :email',
                [
                ':email' => $email
                ]
            )->fetch()
        );
    }

    /**
     * @param $pseudo
     *
     * @return User
     */
    public function getUserByPseudo($pseudo): User
    {
        return new User(
            $this->database->request(
                'SELECT id, pseudo, password, email, email_token AS emailToken,
                           register_at AS registerAt, connexion_at AS connexionAt,
                            rank FROM user WHERE pseudo = :pseudo',
                [
                ':pseudo' => $pseudo
                ]
            )->fetch()
        );
    }

    /**
     * @param int $userId
     *
     * @return User
     */
    public function getUserById(int $userId)
    {
        return new User(
            $this->database->request(
                'SELECT id, pseudo, password, email, email_token AS emailToken,
                         register_at AS registerAt, connexion_at AS connexionAt,
                          rank FROM user WHERE id = :userId LIMIT 0, 1',
                [
                ':userId' => $userId
                ]
            )->fetch()
        );
    }

    /**
     * @param User $rankAdmin
     *
     * @return mixed
     */
    public function getRank(User $rankAdmin)
    {
        return $this->database->request(
            'SELECT * FROM blog.user  WHERE rank = :rankAdmin',
            [
            ':rankAdmin' => intval($rankAdmin->getRank())
            ]
        )->fetchAll();
    }

    /**
     * @return mixed
     */
    public function allusers()
    {
        return $this->database->request('SELECT * FROM user')->fetchAll();
    }

    /**
     * @param $pseudo
     *
     * @return User
     */
    public function allArticlesByPseudo($pseudo): User
    {
        return new User(
            $this->database->request(
                'SELECT * FROM user WHERE pseudo = :pseudo',
                [
                ':pseudo' => $pseudo
                ]
            )->fetch()
        );
    }
}
