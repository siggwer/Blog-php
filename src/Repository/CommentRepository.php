<?php

namespace App\Repository;

use Framework\Connexion;

class CommentRepository extends connexion
{
    //Returns a comment related to the article
    public function getCheckComment($id)
    {
        //var_dump($id);
        $bdd = $this->getBdd();
        $comments = $bdd->prepare("SELECT `article`.`id` AS articleId, `title`, `chapo`, `content`, DATE_FORMAT(`publication_date`, '%d/%m/%Y') AS creation_date_fr, `author_id`, `comment`.`id`, `comments`, `author`, DATE_FORMAT(`comment_date`, '%d/%m/%Y') AS update_date, `comment`.`article_id` FROM `article` LEFT JOIN `comment` ON `comment`.`article_id` = `article`.`id`  WHERE article.id = :id ORDER BY `comment`.`comment_date` DESC ");
        $comments->ExecuteRequest(array($id));
        if(\count($comments) > 0)
            return $comments->fetch();
        else
            echo "Une erreur est survenue. Merci de ressayer plus tard.";

    }

    //Insert a new comment related to the article
    function getAddComment($param = [])
    {
        //var_dump($param);
        $sql=("INSERT INTO comment(comments, author, article_id, comment_date) VALUES(:comments, :author, :article_id, NOW())");
        $this->ExecuteRequest($sql, array($param['comments'],\PDO::PARAM_STR, $param['author'], \PDO::PARAM_STR, $param['article_id'],\PDO::PARAM_STR));

    }

}