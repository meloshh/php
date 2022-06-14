<?php

use Framework\Configuration;

$config = new Configuration();

$config->programName = 'Example program';

$config->routeFilepaths = [
    'modules/main/routes.php',
];

$config->sqlHost = $_ENV['SQL_HOST'];
$config->sqlPort = $_ENV['SQL_PORT'];
$config->sqlUsername = $_ENV['SQL_USERNAME'];
$config->sqlPassword = $_ENV['SQL_PASSWORD'];
$config->sqlDatabase = $_ENV['SQL_DATABASE'];

$config->migrations = [
    \Framework\Migrations\CreateMigrationsTable::class,
    \Modules\Main\Migrations\CreateUsers::class,
];

$config->encryptionKey = $_ENV['ENCRYPTION_KEY'];

return $config;
