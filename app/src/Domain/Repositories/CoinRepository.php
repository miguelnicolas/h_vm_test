<?php

namespace App\Domain\Repositories;

use App\Domain\Repositories\Inventory;
use App\Infrastructure\Storage\MemoryStorage;

/**
 * Represents the change in the machine
 */
class CoinRepository extends Inventory
{
	public function __construct()
	{
		parent::__construct('COINS');
	}
}