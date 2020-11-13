<?php

require __DIR__ . '/config/bootstrap.php';

use App\Interfaces\Console;

$console = new Console;
$console->run();
