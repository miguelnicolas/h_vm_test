<?php

namespace App\Infrastructure\Storage;

use App\Infrastructure\StorageInterface;

class MemoryStorage implements StorageInterface
{
	private $store = [];

	public function count($dataset, $value): int
	{
		$count = 0;
		if(!array_key_exists($dataset, $this->store)) {
			return $count;
		}

		foreach($this->store[$dataset] as $dataValue) {
			if($dataValue == $value) $count++;
		}
		return $count;
	}

	public function add($dataset, $value): bool
	{
		!array_key_exists($dataset, $this->store) && $this->store[$dataset] = [];
		array_push($this->store[$dataset], $value);
		return true;
	}

	public function get($dataset, $value, int $qty = 1): array
	{
		$return = [];
		if(!array_key_exists($dataset, $this->store) || $qty < 1) {
			return $return;
		}
		foreach($this->store[$dataset] as $id => $dataValue) {
			if($dataValue == $value) {
				$return[$id] => 
			}
		}
		return $return;
	}

	public function remove($dataset, $ids): void
	{
		!is_array($ids) && $ids = array($ids);
		foreach($ids as $id) {
			@unset($this->store[$dataset][$id]);
		}
	}
}