<?php

namespace Modules\Main\Migrations;

use Framework\Migrations\IMigration;
use Framework\SQL;

class CreateUsers implements IMigration
{
    public function run()
    {
        $sql = SQL::getInstance();
        $sql->executeQuery('CREATE TABLE users (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at DATETIME
        )');
    }

    public function rollback()
    {
        $sql = SQL::getInstance();
        $sql->executeQuery('DROP TABLE users');
    }


}