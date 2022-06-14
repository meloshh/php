<?php

namespace Framework;

use Framework\CliCommands\CreateDatabase;
use Framework\CliCommands\GenerateEncryptionKey;
use Framework\CliCommands\Migrate;
use Framework\CliCommands\MigrateRollback;

class Configuration
{
    public function __construct()
    {
        $this->allCliCommands = $this->builtinCliCommands;
    }

    public string $programName = '';
    // relative to program root
    public array $routeFilepaths = [];
    public string $sqlHost;
    public string $sqlPort;
    public string $sqlUsername;
    public string $sqlPassword;
    public string $sqlDatabase;
    public int $sessionExpirationMinutes = 120;
    // relative to program root
    public array $migrations = [];
    public string $encryptionKey;




    public function addCliCommands(array $commands)
    {
        $this->additionalCliCommands = $commands;
        $this->allCliCommands = array_merge($this->builtinCliCommands, $this->additionalCliCommands);
    }

    public function getCliCommands()
    {
        return $this->allCliCommands;
    }


    // cli
    protected array $additionalCliCommands = [];

    protected $builtinCliCommands = [
        'migrate' => Migrate::class,
        'migrate:rollback' => MigrateRollback::class,
        'createdb' => CreateDatabase::class,
        'encryption:key' => GenerateEncryptionKey::class,
    ];

    protected array $allCliCommands = [];
}