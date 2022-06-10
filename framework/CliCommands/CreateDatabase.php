<?php

namespace Framework\CliCommands;

use Framework\SQL;

class CreateDatabase implements ICliCommand
{
    protected string $collation = 'utf8mb4_unicode_ci';

    public function run()
    {
        $sql = SQL::getInstance(true);
        $sql->executeQuery('CREATE DATABASE IF NOT EXISTS '.program()->configuration->sqlDatabase
        .' COLLATE '.$this->collation);

        echo 'Database '.program()->configuration->sqlDatabase.' created with collation '.$this->collation;
    }
}