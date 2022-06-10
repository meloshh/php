<?php

require 'vendor/autoload.php';

define('P_DIR', realpath('').'\\');

$program = new \Framework\Program();
$program->run();
