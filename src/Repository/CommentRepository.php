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
            'SELECT * FROM comment
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
            'SELECT * FROM `comment`
        WHERE article_id = :id', [
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
            'SELECT * FROM `comment`
        LEFT JOIN `article` ON `comment`.`article_id` = `article`.`id`
          WHERE article_id = :id
           AND validated = 1
            ORDER BY comment_date DESC', [
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
            VALUES(:author, :comments, NOW(), :article_id)', [
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
        WHERE article_id = :id', [
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
	    WHERE article_id = :id', [
            ':id' => $id
            ]
        )->fetch();
    }

    /**
     * @param $comment
     *
     * @return PdoStatementInterface
     */
    public function validatedComment($comment): PdoStatementInterface
    {
        return $this->database->request(
            'UPDATE comment 
        SET validated = :validated 
        WHERE id = :id', [
            'id' => $comment['id'],
            ':validated' => $comment['validated']
            ]
        );

    }

    /**
     * @param $comment
     *
     * @return array|mixed
     */
    public function deleteComment($comment)
    {
        return $this->database->request(
            'DELETE
        FROM comment WHERE id = :id', [
            'id' => $comment['id']
            ]
        )->fetch();
    }
}
