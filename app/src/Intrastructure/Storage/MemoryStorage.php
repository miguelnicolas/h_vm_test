<?php

namespace App\Infrastructure\Storage;

use App\Infrastructure\StorageInterface;
use App\Infrastructure\BaseStorage;

class MemoryStorage extends BaseStorage implements StorageInterface
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
		if(!array_key_exists($dataset, $this->store) || ($qty < 1 && $qty != -1)) {
			return $return;
		}
		$count = 0;
		foreach($this->store[$dataset] as $key => $dataValue) {
			if($dataValue == $value) {
				$count++;
				$return[$key] => $value;

				if($qty != -1 && $count == $qty) {
					break;
				}
			}
		}
		return $return;
	}

	public function remove($dataset, $keys): void
	{
		!is_array($keys) && $keys = array($keys);
		foreach($keys as $key) {
			@unset($this->store[$dataset][$key]);
		}
	}
}