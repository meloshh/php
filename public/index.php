<?php

require '../vendor/autoload.php';

use Framework\Program;

define('P_DIR', realpath('..').'\\');

$program = new Program();
$GLOBALS['program'] = $program;
$program->run();

