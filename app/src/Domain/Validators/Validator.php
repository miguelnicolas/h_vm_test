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
	
	public function getValidValues()
	{
		return $this->validValues;
	}

	public function isValidValue($value) {
		return empty($this->validValues) || in_array($value, $this->validValues);
	}
}