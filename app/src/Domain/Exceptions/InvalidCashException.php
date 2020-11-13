<?php

namespace App\Domain\Exceptions;

use App\Domain\Exceptions\InvalidItemException;

class InvalidCashException extends InvalidItemException
{
	public function getErrorMessage()
	{
		$message = $this->getColorModifier('ERROR').
			'Invalid coin'.(count($this->invalidItems) > 1 ? 's' : '').': '.implode(', ',$this->invalidItems).PHP_EOL.
			'Machine only accepts the following coins: '.implode(', ',$this->acceptedItems).
			$this->getColorModifier();
		return $message;
	}
}