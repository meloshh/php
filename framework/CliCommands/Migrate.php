<?php

namespace Framework\CliCommands;

use Framework\Migrations\IMigration;

class Migrate implements ICliCommand
{
    public function run()
    {
        $program = program();

        if (count($program->configuration->migrations) === 0) {
            echo '0 migrations found';
            return;
        }

        foreach ($program->configuration->migrations as $migrationClass) {
            $obj = new $migrationClass();

            if (! $obj instanceof IMigration) {
                throw new \Exception($migrationClass.' does not implement IMigration');
            }

            $obj->run();
        }
    }
}