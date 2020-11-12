<?php

namespace App\Domain\Repositories;

use App\Domain\Repositories\Inventory;
use App\Infrastructure\Storage\MemoryStorage;

/**
 * Represents the cash inserted into the machine
 */
class CashRepository extends Inventory
{
	public function __construct()
	{
		parent::__construct('CASH');
	}

	public function getCashTotal() {
		$items = $this->getAllInventory();
		return array_sum($items);
	}
}