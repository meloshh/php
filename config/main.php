<?php

use Framework\Configuration;

$config = new Configuration();

$config->programName = 'Example program';

$config->routeFilepaths = [
    'modules/main/routes.php',
];

return $config;
