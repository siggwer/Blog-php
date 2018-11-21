<?php

namespace App\Repository;

use App\Model\Comment;
use Framework\Connexion;

class CommentRepository extends connexion
{
    //Returns a comment related to the article
    /**
     * @param $artId
     * @return array
     */
    public function getComment($artId) {
        $sql = ('SELECT `comment`.`id` AS commentId, `comments`, `author`, DATE_FORMAT(`comment_date`, \'%d/%m/%Y\') AS update_date, `article_id` FROM `comment` WHERE `article_id` = ?');
        $result = $this->sql($sql, [$artId]);
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['commentId'];
            $comments[$commentId] = $this->buildObject($row);
        }
        return $comments;

    }

    /**
     * @param array $row
     * @return Comment
     */
    private function buildObject(array $row) {
        $comments = new Comment();
        $comments->setId($row['commentId']);
        $comments->setComment($row['comments']);
        $comments->setAuthor($row['author']);
        $comments->setCommentDate($row['update_date']);
        $comments->setArticleId($row['article_id']);
        return $comments;
    }



    //Insert a new comment related to the article
    function getAddComment($param = [])
    {
        //var_dump($param);
        $sql=("INSERT INTO comment(comments, author, article_id, comment_date) VALUES(:comments, :author, :article_id, NOW())");
        $this->ExecuteRequest($sql, array($param['comments'],\PDO::PARAM_STR, $param['author'], \PDO::PARAM_STR, $param['article_id'],\PDO::PARAM_STR));

    }

}