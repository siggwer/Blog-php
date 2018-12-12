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
        return $this->database->request('SELECT `article`.`id` AS articleId,`title`, `chapo`, `content`, DATE_FORMAT(`publication_date`, \'%d/%m/%Y\') AS creation_date_fr, `author_id`,`pseudo`, `article`.`id` FROM `user` LEFT JOIN `article` ON `article`.`author_id` = `user`.`id` WHERE `content` IS NOT NULL ORDER BY `publication_date` DESC')->fetchAll();
    }

    /**
     * @param int $articleId
     * @return mixed
     */
    public function getByArticleId(int $articleId)
    {
        return $this->database->request('SELECT * FROM article  WHERE `article`.`id` = :articleId', [
            ':articleId' => $articleId
        ])->fetch();
    }

    /**
     * @param $articleId
     * @return array
     */
    public function insertPost($articleId): array
    {
        $this->database->request('INSERT INTO article(title, chapo, content, author, publication_date) 
            VALUES(:title, :chapo, :content, :author, NOW())', [
            ':title' => $articleId['title'],
            ':chapo' => $articleId['chapo'],
            ':content' => $articleId['content'],
            ':author' => $articleId['author']
            //':img' => $article['img']
        ]);

        $article['id'] = $this->database->lastId();
        return $article;
    }


    /**
     * @param $articleId
     * @return PdoStatementInterface
     */
    public function updatePost($articleId): PdoStatementInterface
    {
        return $this->database->request('UPDATE article
        SET title = :title,
            chapo = :chapo,
            content = :content,
            author_id = :author_id, 
            publication_date = NOW()
        WHERE id = :id', [
            ':id' => $articleId['id'],
            ':title' => $articleId['title'],
            ':chapo' => $articleId['chapo'],
            ':content' => $articleId['content'],
            ':author' => $articleId['author_id']
            //':img' => $post['img']
        ]);
    }

    /**
     * @param int $articleId
     * @return mixed
     */
    public function deletePost(int $articleId)
    {
        return $this->database->request('DELETE FROM article WHERE id = :id', [
            ':id' => $articleId
        ])->fetch();
    }

}