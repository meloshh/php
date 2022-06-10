<?php

require '../vendor/autoload.php';

use Framework\Program;

define('P_DIR', realpath('..').'\\');

$program = new Program();
$program->run();

