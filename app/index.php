<?php

$container = require __DIR__ . '/config/bootstrap.php';

use App\Controllers\ConsoleController;


$console = new ConsoleController;
$console->run();
