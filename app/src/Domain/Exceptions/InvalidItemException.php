<?php

namespace App\Domain\Exceptions;

use App\Application\Exceptions\BaseException;

abstract class InvalidItemException extends BaseException
{
	protected $defaultCode = 422;
	protected $invalidItems;
	protected $acceptedItems;

	public function __construct(array $invalidItems, array $acceptedItems)
	{
		$this->invalidItems = $invalidItems;
		$this->acceptedItems = $acceptedItems;
		parent::__construct($this->getErrorMessage());
	}

	public function getErrorMessage()
	{
		$message = $this->getColorModifier('WARNING').
			'Invalid item'.(count($this->invalidItems) > 1 ? 's' : '').': '.implode(', ',$this->invalidItems).PHP_EOL.
			'Accepted types of items: '.implode(', ',$this->acceptedItems).
			$this->getColorModifier();
		return $message;
	}
}