<?php

namespace App\Domain\Services;

use App\Domain\Validators\Validator;

abstract class BaseSlot
{
	protected $items = [];
	protected $validator;

	public function __construct(Validator $validator, array $items = [])
	{
		// $this->items = $items;
		/*
		 * Doing this way, $items can be a simple array ([1, 1, 0.25, 0.25, 0.05]) or an array of arrays ([[1, 2], [0.25, 2], [0.05, 1]])
		 * This ways its easy to handle incoming stock entries (restocking) or one by one entries (coins being inserted)
		 */
		$this->setItems($items);
		$this->validator = $validator;
	}

	public function setItems(array $items): void
	{
		$this->items = [];
		foreach($items as $item) {
			if(is_array($item)) {
				$breakdownItems = array_fill(0, $item[1], $item[0]);
				$this->items = array_merge($this->items, $breakdownItems);
			} else {
				array_push($this->items, $item);
			}
		}
	}

	public function isEmpty(): bool
	{
		return empty($this->items);
	}

	public function getInvalidItems(): array
	{
		$invalidItems = [];
		foreach($this->items as $item) {
			if(!$this->validator->isValidValue($item)) {
				array_push($invalidItems, $item);
			}
		}
		return $invalidItems;
	}

	public function getValidItems(): array
	{
		return array_diff($this->items, $this->getInvalidItems());
	}

	/**
	 * @return bool True
	 */
	abstract public function validate(): bool;

}