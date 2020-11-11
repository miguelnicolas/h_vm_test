<?php
require __DIR__ . './../../vendor/autoload.php';

use App\Infrastructure\Storage\MemoryStorage;

// Singleton functions
// 

function Storage()
{

	return MemoryStorage::getInstance();
}