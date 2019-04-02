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
        return $this->database->request('SELECT `article`.`id`,`title`, `chapo`, `content`, DATE_FORMAT(`publication_date`, \'%d/%m/%Y\') AS creation_date_fr, `author_id`,`pseudo`,`email`, `article`.`id` FROM `user` LEFT JOIN `article` ON `article`.`author_id` = `user`.`id` WHERE `content` IS NOT NULL ORDER BY `publication_date` DESC')->fetchAll();
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function getByArticleId(int $id)
    {
        return $this->database->request(
            'SELECT `article`.`id`,`title`, `chapo`, `content`, DATE_FORMAT(`publication_date`, \'%d/%m/%Y\') AS creation_date_fr, `author_id`,`pseudo`, `email`, `article`.`id` FROM `user` LEFT JOIN `article` ON `article`.`author_id` = `user`.`id` WHERE `article`.`id` = :id', [
            ':id' => $id
            ]
        )->fetch();
    }

    /**
     * @param string $pseudo
     *
     * @return mixed
     */
    public function getByArticlePseudo(string $pseudo)
    {
        return $this->database->request(
            'SELECT article.id, title, chapo, content, DATE_FORMAT(publication_date, \'%d/%m/%Y à %Hh%imin\') AS creation_date_fr, `author_id`, pseudo, email, email_token, password, register_at, connexion_at, rank, article.id FROM user LEFT JOIN `article` ON article.author_id = user.id WHERE pseudo = :pseudo ORDER BY `publication_date` DESC', [
            ':pseudo' => $pseudo
            ]
        )->fetchAll();
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function insertArticle($id): array
    {
        $this->database->request(
            'INSERT INTO article(title, chapo, content, author_id, publication_date) 
            VALUES(:title, :chapo, :content, :author_id, NOW())', [
            ':title' => $id['title'],
            ':chapo' => $id['chapo'],
            ':content' => $id['content'],
            ':author_id'=> $id['author_id']
            //':img' => $article['img']
            ]
        );

        $article['id'] = $this->database->lastId();
        return $article;
    }


    /**
     * @param $articles
     *
     * @return PdoStatementInterface
     */
    public function updateArticle($articles): PdoStatementInterface
    {
        return $this->database->request(
            'UPDATE article
        SET title = :title,
            chapo = :chapo,
            content = :content,
            update_by = :update_by,
            publication_date = NOW()
        WHERE id = :id', [
            ':id' => $articles['id'],
            ':title' => $articles['title'],
            ':chapo' => $articles['chapo'],
            ':content' => $articles['content'],
            ':update_by' => $articles['update_by']
            //':img' =>  $articles['img']
            ]
        );
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function deleteArticle(int $id)
    {
        return $this->database->request(
            'DELETE FROM article WHERE id = :id', [
            ':id' => $id
            ]
        )->fetch();
    }
}
