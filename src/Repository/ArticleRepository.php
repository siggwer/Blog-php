<?php

namespace App\Repository;

use App\Pdo\Interfaces\PdoDatabaseInterface;
use App\Repository\Interfaces\ArticleRepositoryInterface;

//use App\Pdo\Interfaces\PdoStatementInterface;
class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @var PdoDatabaseInterface
     */
    private $database;

    /**
     * ArticleRepository constructor.
     * @param PdoDatabaseInterface $database
     */
    public function __construct(PdoDatabaseInterface $database){
        $this->database = $database;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->database->request('SELECT `article`.`id` AS articleId,`title`, `chapo`, `content`, DATE_FORMAT(`publication_date`, \'%d/%m/%Y\') AS creation_date_fr, `author_id`,`pseudo`, `article`.`id` FROM `user` LEFT JOIN `article` ON `article`.`author_id` = `user`.`id` WHERE `content` IS NOT NULL ORDER BY `publication_date` DESC')->fetchAll();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getByArticleId(int $id)
    {
        return $this->database->request('SELECT * FROM article  WHERE id = :id', [
            ':id' => $id
        ])->fetch();
    }

    /**
     * @param $post
     * @return array
     */
    public function insertPost($post): array
    {
        $this->database->request('INSERT INTO article(title, chapo, content, author, creation_at, img) 
            VALUES(:title, :chapo, :content, :author, NOW(), :img)', [
            ':title' => $post['title'],
            ':chapo' => $post['chapo'],
            ':content' => $post['content'],
            ':author' => $post ['author'],
            ':img' => $post['img']
        ]);

        $post['id'] = $this->database->lastId();
        return $post;
    }


    /**
     * @param $post
     * @return StatementInterface
     */
    public function updatePost($post): StatementInterface
    {
        return $this->database->request('UPDATE article
        SET title = :title,
            chapo = :chapo,
            content = :content,
            author = :author,
            img = :img, 
            update_at = NOW()
        WHERE id = :id', [
            ':id' => $post['id'],
            ':title' => $post['title'],
            ':chapo' => $post['chapo'],
            ':content' => $post['content'],
            ':author' => $post['author'],
            ':img' => $post['img']
        ]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deletePost(int $id)
    {
        return $this->database->request('DELETE FROM article WHERE id = :id', [
            ':id' => $id
        ])->fetch();
    }

}