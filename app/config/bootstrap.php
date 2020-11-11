<?php
require __DIR__ . './../../vendor/autoload.php';

use App\Domain\VendingMachineApp;
use App\Infrastructure\Storage\MemoryStorage;

// Singleton functions
// 
function App()
{
	return VendingMachineApp::getInstance();
}

function Storage()
{
	return MemoryStorage::getInstance();
}