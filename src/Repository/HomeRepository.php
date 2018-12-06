<?php

namespace App\Repository;

use App\Pdo\Interfaces\PdoDatabaseInterface;
use App\Repository\Interfaces\HomeRepositoryInterface;

//use App\Pdo\Interfaces\PdoStatementInterface;
class HomeRepository implements HomeRepositoryInterface
{
    /**
     * @var PdoDatabaseInterface
     */
    private $database;

    /**
     * HomeRepository constructor.
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

}