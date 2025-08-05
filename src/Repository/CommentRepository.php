<?php

namespace App\Repository;

use App\Pdo\Interfaces\PdoDatabaseInterface;
use App\Pdo\Interfaces\PdoStatementInterface;
use App\Repository\Interfaces\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * @var PdoDatabaseInterface $database
     */
    private $database;

    /**
     * CommentRepository constructor.
     *
     * @param PdoDatabaseInterface $database
     */
    public function __construct(PdoDatabaseInterface $database)
    {
        $this->database = $database;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->database->request(
            'SELECT `comment`.`id`, `comment`.`comments`, `comment`.`author`, 
                        DATE_FORMAT(`comment_date`, \'%d/%m/%Y\ à %Hh%imin\') AS creation_date_fr, 
                        `comment`.`validated`, `article`.`title` FROM comment
        LEFT JOIN `article` ON `comment`.`article_id` = `article`.`id` 
        ORDER BY comment_date DESC'
        )
            ->fetchAll();
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function getComment(int $id)
    {
        return $this->database->request(
            'SELECT `comment`.`id`, `comment`.`comments`, `comment`.`author`,
                        DATE_FORMAT(`comment_date`, \'%d/%m/%Y\ à %Hh%imin\') AS creation_date_fr, 
                        `comment`.`validated` FROM `comment`
        WHERE article_id = :id',
            [
            ':id' => $id
            ]
        )->fetch();
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getCommentById(int $id): array
    {
        return $this->database->request(
            'SELECT `comment`.`id`, `comment`.`comments`, `comment`.`author`,
                        DATE_FORMAT(`comment_date`, \'%d/%m/%Y\ à %Hh%imin\') AS creation_date_fr, 
                        `comment`.`validated`, `article`.`title` FROM `comment`
        LEFT JOIN `article` ON `comment`.`article_id` = `article`.`id`
        WHERE article_id = :id
        AND validated = 1
        ORDER BY comment_date DESC',
            [
                ':id' => $id,
            ]
        )->fetchAll();
    }

    /**
     * @param $comment
     *
     * @return array
     */
    public function insertComment($comment): array
    {
        $this->database->request(
            'INSERT INTO comment(
            author, comments, comment_date, article_id) 
            VALUES(:author, :comments, NOW(), :article_id)',
            [
            ':author' => $comment['author'],
            ':comments' => $comment['comments'],
            'article_id' => $comment['article_id']
            ]
        );

        $comment['id'] = $this->database->lastId();
        return $comment;
    }

    /**
     * @param $comment
     *
     * @return PdoStatementInterface
     */
    public function updateComment($comment): PdoStatementInterface
    {
        return $this->database->request(
            'UPDATE comment
        SET id = :id,
            author = :author,
            comments = :comments,
            comment_date = NOW(),
            article_id = :article_id,
            validated = :validated
        WHERE article_id = :id',
            [
            ':author' => $comment['author'],
            ':comment' => $comment['comment'],
            ':article_id' => $comment['id'],
            ':validated' => $comment['validated']
            ]
        );
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function getCommentForvalidated(int $id)
    {
        return $this->database->request(
            'SELECT `comment`.`id`,
        `comment`.`validated`, `article`.`author_id`, `comment`.`article_id`, `user`.`email` 
        FROM `comment` 
        LEFT JOIN `article` 
        ON `comment`.`article_id` = `article`.`id` 
	    LEFT JOIN `user` 
	    ON `article`.`author_id` = `user`.`id`
	    WHERE `comment`.`id`= :id',
            [
            ':id' => $id
            ]
        )->fetch();
    }

    /**
     * @param int $id
     *
     * @return PdoStatementInterface
     */
    public function validatedComment(int $id): PdoStatementInterface
    {
        return $this->database->request(
            'UPDATE comment 
        SET validated = 1 
        WHERE id = :id',
            [
                'id' => $id
            ]
        );
    }

    /**
     * @param int $id
     *
     * @return PdoStatementInterface|array
     */
    public function deleteComment(int $id)
    {
        return $this->database->request(
            'DELETE
        FROM comment 
        WHERE id = :id',
            [
            'id' => $id
            ]
        );
    }
}
