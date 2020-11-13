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

/*use Symfony\Component\DependencyInjection\ContainerBuilder;

// creating an empty container builder
$containerBuilder = new ContainerBuilder();

dump($containerBuilder);

$serviceContainer = require 'services.php';*/