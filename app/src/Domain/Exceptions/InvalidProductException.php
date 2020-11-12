<?php

namespace App\Domain\Exceptions;

use App\Application\Exceptions\BaseException;

class InvalidProductException extends InvalidItemException
{
	public function getErrorMessage()
	{
		$message = $this->getColorModifier('WARNING').
			'Returning invalid product'.(count($this->invalidItems) > 1 ? 's' : '').': '.implode(', ',$this->invalidItems).PHP_EOL.
			'Machine only accepts the following products: '.implode(', ',$this->acceptedItems).
			$this->getColorModifier();
		return $message;
	}
}