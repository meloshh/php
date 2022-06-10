<?php

namespace Framework\CliCommands;

use Framework\Migrations\IMigration;
use Framework\Migrations\Migrator;

class Migrate implements ICliCommand
{
    public function run()
    {
        $program = program();

        if (count($program->configuration->migrations) === 0) {
            echo '0 migrations found';
            return;
        }

        $migrator = new Migrator();
        $migrator->run();
    }
}