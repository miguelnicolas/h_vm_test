<?php

namespace App\Domain\Validators;

abstract class Validator
{
	protected $validValues = [];

	public function __construct(array $validValues = null)
	{
		if($validValues) {
			$this->validValues = $validValues;
		}
	}
	
	public function setValidValues($values): void
	{
		$this->validValues = $values;
	}
	
	public function getValidValues(): array
	{
		return $this->validValues;
	}

	public function isValidValue($value): bool
	{
		return empty($this->validValues) || in_array($value, $this->validValues);
	}
}