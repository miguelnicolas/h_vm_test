<?php

namespace App\Domain\Validators;

use App\Domain\Validators\Validator;

class ProductValidator extends Validator
{
	public function __construct(array $validValues = null)
	{
		empty($validValues) && $validValues = App()->productRepository->getCatalogProductNames();
		$this->validValues = $validValues;
	}
}