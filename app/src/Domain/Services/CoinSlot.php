<?php

namespace App\Domain\Services;

use App\Domain\Exceptions\InvalidCoinException;

class CoinSlot extends BaseSlot
{
	/**
	 * @return bool True
	 * @throws InvalidCoinException
	 */
	public function validate(): bool
	{
		$invalidCoins = $this->getInvalidItems();
		if(!empty($invalidCoins)) {
			throw new InvalidCoinException($invalidCoins, $this->validator->getValidValues());
		}
		
		return true;
	}

}