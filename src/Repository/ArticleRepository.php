<?php

namespace App\Repository;

use App\Model\Article;
use Framework\Connexion;

class ArticleRepository extends Connexion
{
    //Returns an article related to the user
    /**
     * @return array
     */
    public function getArticles() {
        $sql = ('SELECT `article`.`id` AS articleId,`title`, `chapo`, `content`, DATE_FORMAT(`publication_date`, \'%d/%m/%Y\') AS creation_date_fr, `author_id`,`pseudo`, `article`.`id` FROM `user` LEFT JOIN `article` ON `article`.`author_id` = `user`.`id` WHERE `content` IS NOT NULL ORDER BY `publication_date` DESC');
        $result = $this->sql($sql);
        $articles = [];
        foreach ($result as $row){
            $articlesId = $row['articleId'];
            $articles[$articlesId] = $this->buildObject($row);
        }
        return $articles;

    }

    /**
     * @param $artId
     * @return array
     */
    public function getArticlesDetails($artId) {
        $sql = ('SELECT `article`.`id` AS articleId,`title`, `chapo`, `content`, DATE_FORMAT(`publication_date`, \'%d/%m/%Y\') AS creation_date_fr, `author_id`,`pseudo` FROM `user` LEFT JOIN `article` ON `article`.`author_id` = `user`.`id` WHERE `article`.`id` = ?');
        $result = $this->sql($sql, [$artId]);
        $articles = [];
        foreach ($result as $row) {
            $articlesId = $row['articleId'];
            $articles[$articlesId] = $this->buildObject($row);
        }
        return $articles;
    }

    /**
     * @param array $row
     * @return Article
     */
    private function buildObject(array $row) {
        $articles = new Article();
        $articles->setId($row['articleId']);
        $articles->setTitle($row['title']);
        $articles->setChapo($row['chapo']);
        $articles->setContent($row['content']);
        $articles->setPublicationDate($row['creation_date_fr']);
        $articles->setAuthor($row['author_id']);
        $articles->setPseudo($row['pseudo']);
        return $articles;
    }
}

