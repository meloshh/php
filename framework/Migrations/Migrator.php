<?php

namespace Framework\Migrations;

use Framework\Queries;
use Framework\SQL;

class Migrator
{
    protected SQL $sql;

    public function __construct()
    {
        $this->sql = SQL::getInstance();
    }

    public function run()
    {
        if (! $this->tableExists('migrations')) {
            $this->migrateAll();
        }

        $this->migrateSteps();
    }

    public function rollback()
    {
        if (! $this->tableExists('migrations')) {
            return;
        }

        $batch = $this->sql->executeQuery('SELECT MAX(batch) as max_batch FROM migrations')->fetch()['max_batch'];

        $ranMigrations = $this->sql->executeQuery('SELECT * FROM migrations WHERE batch = ? ORDER BY id DESC', [$batch]);

        foreach ($ranMigrations as $ranMigration) {
            echo "Rolling back ".$ranMigration['class_name']."\n";
            $migration = new $ranMigration['class_name']();

            if (!$migration instanceof IMigration) {
                throw new \Exception('Class does not implement IMigration');
            }

            $migration->rollback();

            $this->sql->executeQuery('DELETE FROM migrations WHERE id = ?', [$ranMigration['id']]);

            echo "Rolled back ".$ranMigration['class_name']."\n";
        }
    }

    protected function tableExists(string $tableName): bool
    {
        $result = $this->sql->executeQuery(Queries::tableExists('migrations'));

        return $result->rowCount() > 0;
    }

    protected function migrateAll()
    {
        foreach (program()->configuration->migrations as $migrationClass) {
            echo "Migrating $migrationClass'\n";
            $migration = new $migrationClass();

            if (!$migration instanceof IMigration) {
                throw new \Exception('Class does not implement IMigration');
            }

            $migration->run();

            $this->sql->executeQuery('INSERT INTO migrations (class_name, batch) VALUES (?, ?)', [
                $migrationClass,
                1,
            ]);

            echo "Finished migrating $migrationClass\n";
        }
    }

    protected function migrateSteps()
    {
        $ranMigrations = $this->sql->executeQuery('SELECT * FROM migrations')->fetchAll();

        $batch = $this->sql->executeQuery('SELECT MAX(batch) as max_batch FROM migrations')->fetch()['max_batch'] + 1;

        foreach (program()->configuration->migrations as $i => $migrationClass) {
            $migration = new $migrationClass();

            if (!$migration instanceof IMigration) {
                throw new \Exception('Class does not implement IMigration');
            }

            // check if this was migrated
            if ($this->classMigrated($migrationClass, $ranMigrations)) {
                echo "Already migrated $migrationClass\n";
                continue;
            }

            $migration->run();

            $this->sql->executeQuery('INSERT INTO migrations (class_name, batch) VALUES (?, ?)', [
                $migrationClass,
                $batch,
            ]);

            echo "Finished migrating $migrationClass\n";
        }
    }

    protected function classMigrated(string $class, array $ranMigrations): bool
    {
        foreach ($ranMigrations as $ranMigration) {
            if ($ranMigration['class_name'] === $class) {
                return true;
            }
        }

        return false;
    }
}