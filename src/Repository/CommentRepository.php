<?php

namespace App\Repository;

use App\Pdo\Interfaces\PdoDatabaseInterface;
use App\Pdo\Interfaces\PdoStatementInterface;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * @var PdoDatabaseInterface $database
     */
    private $database;

    /**
     * CommentRepository constructor.
     * @param PdoStatementInterface $database
     */
    public function __construct(PdoStatementInterface $database)
    {
        $this->database = $database;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->database->request('SELECT * FROM comment')->fetchAll();
    }

    /**
     * @param int $articleId
     * @return mixed
     */
    public function getComment(int $articleId)
    {
        return $this->database->request('SELECT * FROM comment  WHERE id = :id', [
            ':id' => $articleId
        ])->fetch();
    }

    /**
     * @param int $articleId
     * @param bool $checkValidated
     * @return array
     */
    public function getCommentById(int $articleId): array
    {
        return $this->database->request('
            SELECT * FROM `comment` LEFT JOIN `article` ON `comment`.`article_id` = `article`.`id`  WHERE article_id = :articleId ORDER BY comment_date DESC', [
                ':article_id' => $articleId,
        ])->fetchAll();
    }

    /**
     * @param $comment
     * @return array
     */
    public function insertComment($comment): array
    {
        $this->database->request('INSERT INTO comment(id, author, comments, comment_date) 
            VALUES(:id, :author, :comments, NOW())', [
            'id'=>$comment['id'],
            ':author' => $comment['author'],
            ':comments' => $comment['comments'],
        ]);

        $comment['id'] = $this->database->lastId();
        return $comment;
    }

    /**
     * @param $comment
     * @return PdoStatementInterface
     */
    public function updateComment($comment): PdoStatementInterface
    {
        return $this->database->request('UPDATE comment
        SET id = :id,
            author = :author,
            comments = :comments,
            comment_date = NOW(),
        WHERE id = :id', [
            ':id' =>$comment['id'],
            ':post_id' => $comment['post_id'],
            ':author' => $comment['author'],
            ':comment' => $comment['comment'],
            //':validated' => $comment['validated']
        ]);
    }
}