<?php

namespace App\Domain\Exceptions;

use App\Application\Exceptions\BaseException;

class InvalidCoinException extends BaseException
{
	protected $defaultCode = 422;
	private $invalidCoins;
	private $acceptedCoins;

	public function __construct(array $invalidCoins, array $acceptedCoins)
	{
		$this->invalidCoins = $invalidCoins;
		$this->acceptedCoins = $acceptedCoins;
		parent::__construct($this->getErrorMessage());
	}

	public function getErrorMessage()
	{
		$message = $this->getColorModifier('WARNING').
			'Returning invalid coin'.(count($this->invalidCoins) > 1 ? 's' : '').': '.implode(', ',$this->invalidCoins).PHP_EOL.
			'Machine only accepts the following coins: '.implode(', ',$this->acceptedCoins).
			$this->getColorModifier();
		return $message;
	}
}