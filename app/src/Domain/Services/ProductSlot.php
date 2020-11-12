<?php

namespace App\Domain\Services;

use App\Domain\Exceptions\InvalidProductException;

class ProductSlot extends BaseSlot
{

	/**
	 * @return bool True
	 * @throws InvalidCoinException
	 */
	public function validate(): bool
	{
		$invalidProducts = $this->getInvalidItems();
		if(!empty($invalidProducts)) {
			throw new InvalidProductException($invalidProducts, $this->validator->getValidValues());
		}
		
		return true;
	}

}