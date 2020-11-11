<?php

namespace App\Domain\Validators;

abstract class Validator
{
	protected $validValues = [];
	
	public function setValidValues($validValues)
	{
		$this->validValues = $validValues;
	}
}