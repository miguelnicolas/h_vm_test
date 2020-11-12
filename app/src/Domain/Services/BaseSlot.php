<?php

namespace App\Domain\Services;

use App\Domain\Validators\Validator;

abstract class BaseSlot
{
	protected $items = [];
	protected $validator;

	public function __construct(array $items, 
								Validator $validator)
	{
		$this->items = $items;
		$this->validator = $validator;
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