<?php

namespace App\Domain\Validators;

use App\Domain\Validators\Validator;
use App\Domain\Enum\ValidCoins;

class CoinValidator extends Validator
{
	public function __construct(array $validValues = null)
	{
		if($validValues) {
			$this->setValidValues($validValues);
		}
	}

	public function isValidCoin($coin) {
		return in_array($coin, $this->validValues);
	}
}