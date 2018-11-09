<?php

namespace App\Repository;

use App\Model\Article;
use Framework\Connexion;

class ArticleRepository extends Connexion
{
    //Returns an article related to the user
    public function getArticles()
    {
        $sql = ('SELECT `article`.`id`,`title`, `chapo`, `content`, DATE_FORMAT(`publication_date`, \'%d/%m/%Y\') AS creation_date_fr, `author_id`,`pseudo`, `article`.`id` FROM `user` LEFT JOIN `article` ON `article`.`author_id` = `user`.`id` WHERE `content` IS NOT NULL ORDER BY `publication_date` DESC');
        $result = $this->sql($sql);
        $articles = [];
        foreach ($result as $row){
            $articlesId = $row['id'];
            $articles[$articlesId] = $this->buildObject($row);
        }
        return $articles;

    }
    //Returns a comment related to the article
    public function getArticlesDetails($id)
    {
        $bdd = $this->getBdd();
        $articles = $bdd->prepare("SELECT `article`.`id` AS articleId, `title`, `chapo`, `content`, DATE_FORMAT(`publication_date`, '%d/%m/%Y') AS creation_date_fr, `author_id`, `comment`.`id`, `comments`, `author`, DATE_FORMAT(`comment_date`, '%d/%m/%Y') AS update_date, `comment`.`article_id` FROM `article` LEFT JOIN `comment` ON `comment`.`article_id` = `article`.`id`  WHERE article.id = :id  ORDER BY `comment`.`comment_date` DESC");
        $articles->execute(array($id));
        if(\count($articles) > 0)
            return $articles->fetch();
        else
            echo "Une erreur est survenue. Merci de ressayer plus tard.";
    }

    private function buildObject(array $row)
    {
        $articles = new Article();
        $articles->setId($row['id']);
        $articles->setTitle($row['title']);
        $articles->setChapo($row['chapo']);
        $articles->setContent($row['content']);
        $articles->setPublicationDate($row['creation_date_fr']);
        $articles->setAuthor($row['author_id']);
        //$articles->setEdited($row['edited']);
        return $articles;
    }
}

