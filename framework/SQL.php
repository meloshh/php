<?php

namespace Framework;

class SQL
{
    private static null|SQL $instance = null;
    private \PDO $pdo;
    public bool $transactionActive = false;

    private function __construct(bool $noDb = false) {
        $this->pdo = new \PDO(static::makeDSN(program()->configuration->sqlHost,
            program()->configuration->sqlPort,
            $noDb ? null : program()->configuration->sqlDatabase), program()->configuration->sqlUsername, program()->configuration->sqlPassword, [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);
    }

    public static function getInstance(bool $noDb = false): SQL
    {
        if (! isset(static::$instance)) {
            static::$instance = new SQL($noDb);
        }

        return static::$instance;
    }

    public function executeQuery(string $query, array $bindings = null): \PDOStatement
    {
        $statement = $this->pdo->prepare($query);

        if ($bindings) {
            $statement->execute($bindings);
        } else {
            $statement->execute();
        }

        return $statement;
    }

    public function beginTransaction(): bool
    {
        if ($this->transactionActive) {
            return false;
        }

        if ($success = $this->pdo->beginTransaction()) {
            $this->transactionActive = true;
        }

        return $success;
    }

    public function commitTransaction(): bool
    {
        if (! $this->transactionActive) {
            return false;
        }

        if ($success = $this->pdo->commit()) {
            $this->transactionActive = false;
        }

        return $success;
    }

    public function rollbackTransaction(): bool
    {
        if (! $this->transactionActive) {
            return false;
        }

        if ($success = $this->pdo->rollBack()) {
            $this->transactionActive = false;
        }

        return $success;
    }


    protected static function makeDSN(string $host, int $port, string $dbname = null): string
    {
        $dsn = 'mysql:host='.$host.';port='.$port;

        if ($dbname) {
            $dsn .= ';dbname='.$dbname;
        }

        return $dsn;
    }
}