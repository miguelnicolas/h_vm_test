<?php

namespace App\Domain\Services;

use App\Domain\Exceptions\InvalidCashException;

class CashSlot extends BaseSlot
{
	/**
	 * @return bool True
	 * @throws InvalidCoinException
	 */
	public function validate(): bool
	{
		$invalidCoins = $this->getInvalidItems();
		if(!empty($invalidCoins)) {
			throw new InvalidCashException($invalidCoins, $this->validator->getValidValues());
		}
		
		return true;
	}
}