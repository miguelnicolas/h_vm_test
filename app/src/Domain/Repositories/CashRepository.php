<?php

namespace App\Domain\Repositories;

use App\Domain\Repositories\Inventory;

/**
 * Represents the cash inserted in the machine
 */
class CashRepository extends Inventory
{
	public function __construct(StorageInterface $storage)
	{
		parent::__construct($storage, 'CASH');
	}

	public function getCashTotal() {
		$items = $this->getAll();
		return array_sum($items);
	}
}