<?php

namespace App\Domain\Validators;

use App\Domain\Validators\Validator;
use App\Domain\Enum\ValidCoins;

class CoinValidator extends Validator
{
	public function __construct(array $validValues)
	{
		$this->validValues = $validValues;
	}
}