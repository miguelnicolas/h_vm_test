<?php

namespace App\Domain\Repositories;

use App\Infrastructure\Storage\Storage;

abstract class Inventory
{
	private $dataset;

	public function __construct(string $dataset)
	{
		$this->dataset = $dataset;
	}

	public function getDataset()
	{
		return $this->dataset;
	}

	public function store(): Storage
	{
		return Storage();
	}

	public function getStock($value): int
	{
		return $this->store()->count($this->dataset, $value) >= $qty;
	}

	public function hasStock($value, $qty): bool
	{
		return $this->getStock($value) >= $qty;
	}

	public function getAllInventory(): array
	{
		return $this->store()->getAll($this->dataset);
	}

	public function flush(): array
	{
		return $this->store()->flush($this->dataset);
	}

	public function incrementStock($value, int $qty = 1): bool
	{
		if($qty >= 1) {
			for($i = 1; $i <= $qty; $i++) {
				$this->store()->add($this->dataset, $value);
			}
		}
		return true;
	}

	public function decrementStock($value, int $qty = 1): bool
	{
		$items = $this->store()->get($this->dataset, $value, $qty);

		if(!empty($items)) {
			$this->store()->remove($this->dataset, array_keys($items));
		}
		return true;
	}

	public function getStatusSummary()
	{
		$inventory = $this->getAllInventory();

	}
}