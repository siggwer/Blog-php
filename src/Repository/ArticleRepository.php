<?php

namespace App\Repository;

use App\Pdo\Interfaces\PdoDatabaseInterface;
use App\Pdo\Interfaces\PdoStatementInterface;
use App\Repository\Interfaces\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @var PdoDatabaseInterface $database
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
        return $this->database->request('SELECT `article`.`id`,`title`, `chapo`, `content`, DATE_FORMAT(`publication_date`, \'%d/%m/%Y\') AS creation_date_fr, `author_id`,`pseudo`, `article`.`id` FROM `user` LEFT JOIN `article` ON `article`.`author_id` = `user`.`id` WHERE `content` IS NOT NULL ORDER BY `publication_date` DESC')->fetchAll();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getByArticleId(int $id)
    {
        return $this->database->request('SELECT `article`.`id`,`title`, `chapo`, `content`, DATE_FORMAT(`publication_date`, \'%d/%m/%Y\') AS creation_date_fr, `author_id`,`pseudo`, `article`.`id` FROM `user` LEFT JOIN `article` ON `article`.`author_id` = `user`.`id` WHERE `article`.`id` = :id', [
            ':id' => $id
        ])->fetch();
    }

    /**
     * @param $id
     * @return array
     */
    public function insertPost($id): array
    {
        $this->database->request('INSERT INTO article(title, chapo, content, author, publication_date) 
            VALUES(:title, :chapo, :content, :author, NOW())', [
            ':title' => $id['title'],
            ':chapo' => $id['chapo'],
            ':content' => $id['content'],
            ':author' => $id['author']
            //':img' => $article['img']
        ]);

        $article['id'] = $this->database->lastId();
        return $article;
    }


    /**
     * @param $id
     * @return PdoStatementInterface
     */
    public function updatePost($id): PdoStatementInterface
    {
        return $this->database->request('UPDATE article
        SET title = :title,
            chapo = :chapo,
            content = :content,
            author_id = :author_id, 
            publication_date = NOW()
        WHERE id = :id', [
            ':id' => $id['id'],
            ':title' => $id['title'],
            ':chapo' =>$id['chapo'],
            ':content' => $id['content'],
            ':author' => $id['author_id']
            //':img' => $post['img']
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