<?php

namespace App\Domain\Exceptions;

use App\Domain\Exceptions\InvalidItemException;

class InvalidProductException extends InvalidItemException
{
	public function getErrorMessage()
	{
		$message = $this->getColorModifier('ERROR').
			'Invalid product'.(count($this->invalidItems) > 1 ? 's' : '').': '.implode(', ',$this->invalidItems).PHP_EOL.
			'Machine only accepts the following products: '.implode(', ',$this->acceptedItems).
			$this->getColorModifier();
		return $message;
	}
}