<?php

namespace Framework\Migrations;

use Framework\SQL;

class CreateMigrationsTable implements IMigration
{

    public function run()
    {
        $sql = SQL::getInstance();
        $sql->executeQuery('CREATE TABLE migrations (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            class_name VARCHAR(255) NOT NULL,
            batch INT UNSIGNED NOT NULL
        )');
    }

    public function rollback()
    {
        $sql = SQL::getInstance();
        $sql->executeQuery('DROP TABLE migrations');
    }
}