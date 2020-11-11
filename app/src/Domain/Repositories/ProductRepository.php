<?php

namespace App\Domain\Repositories;

use App\Domain\Repositories\Inventory;
use App\Domain\Models\Product;
use App\Infrastructure\Storage\MemoryStorage;

/**
 * Represents the products in the machine
 */
class ProductRepository extends Inventory
{
	private $catalog = [];

	public function __construct()
	{
		parent::__construct('PRODUCTS');
	}

	public function addProductToCatalog(Product $product): void
	{
		if(!$this->isInCatalog($product)){
			array_push($this->catalog, $product);
		}
	}

	public function isInCatalog(Product $product): bool
	{
		$isPresent = false;
		foreach($this->catalog as $productInCatalog) {
			if($product->getName() == $productInCatalog->getName()) {
				$isPresent = true;
				break;
			}
		}
		return $isPresent;
	}
}