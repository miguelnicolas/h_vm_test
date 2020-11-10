<?php

namespace App\Domain\Repositories;

use App\Domain\Repositories\Inventory;

/**
 * Represents the products in the machine
 */
class ProductRepository extends Inventory
{

	public function __construct(StorageInterface $storage)
	{
		parent::__construct($storage, 'PRODUCTS');
	}
}