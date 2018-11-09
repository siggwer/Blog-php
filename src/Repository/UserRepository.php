<?php

namespace App\Repository;

use Framework\Connexion;


class UserRepository extends connexion
{
    //Get the list of items from a logged in member
    public function getAdministration($pseudo)
    {
        //var_dump($pseudo);
        $bdd = $this->getBdd();
        $user = $bdd->prepare("SELECT user.id AS userId, article.id AS articleId, title, chapo, content, DATE_FORMAT(publication_date, '%d/%m/%Y à %Hh%imin%ss') AS creation_date_fr, author_id, pseudo, email FROM user LEFT JOIN article ON article.author_id = user.id WHERE pseudo = :pseudo");
        $user->ExecuteRequest(array($pseudo));
        if(\count($user) > 0)
            return $user->fetch();
        else
            echo "Le pseudo n'exitse pas merci de vous enregistrer.";
    }
}