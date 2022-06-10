<?php

namespace Framework\CliCommands;

use Framework\Migrations\Migrator;

class MigrateRollback implements ICliCommand
{

    public function run()
    {
        $migrator = new Migrator();
        $migrator->rollback();
    }
}