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

	public function __construct(array $products = [])
	{
		$this->catalog = $products;
		parent::__construct('PRODUCTS');
	}

	public function addProductToCatalog(Product $product): void
	{
		if(is_null($this->getProductByName($product->getName()))) {
			array_push($this->catalog, $product);
		}
	}

	public function getProductByName($productName): ?Product
	{
		foreach($this->catalog as $product) {
			if($productName == $product->getName()) {
				return $product;
			}
		}
		return null;
	}

	public function getCatalogProductNames(): array
	{
		$productNames = [];
		foreach($this->catalog as $product) {
			array_push($productNames, $product->getName());
		}
		return $productNames;
	}
}