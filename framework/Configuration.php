<?php

namespace Framework;

use Framework\CliCommands\Migrate;

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

    public function addCliCommands(array $commands)
    {
        $this->additionalCliCommands = $commands;
        $this->allCliCommands = array_merge($this->builtinCliCommands, $this->additionalCliCommands);
    }

    public function getCliCommands()
    {
        return $this->allCliCommands;
    }



    protected array $additionalCliCommands = [];

    protected $builtinCliCommands = [
        'migrate' => Migrate::class
    ];

    protected array $allCliCommands = [];
}