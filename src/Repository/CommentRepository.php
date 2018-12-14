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
        return $this->database->request('SELECT * FROM comment')->fetchAll();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getComment(int $id)
    {
        return $this->database->request('SELECT * FROM comment  WHERE article_id = :id', [
            ':id' => $id
        ])->fetch();
    }

    /**
     * @param int $id
     * @return array
     */
    public function getCommentById(int $id): array
    {
        return $this->database->request('
            SELECT * FROM `comment` LEFT JOIN `article` ON `comment`.`article_id` = `article`.`id`  WHERE article_id = :id ORDER BY comment_date DESC', [
                ':id' => $id,
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