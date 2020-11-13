<?php

namespace App\Domain\Exceptions;

use App\Application\Exceptions\BaseException;
use App\Domain\Models\Product;

class NotEnoughMoneyException extends BaseException
{
	protected $defaultCode = 404;
	private $product;
	private $availableCredit;

	public function __construct(Product $product, float $availableCredit)
	{
		$this->product = $product;
		$this->availableCredit = $availableCredit;
		parent::__construct($this->getErrorMessage());
	}

	public function getErrorMessage()
	{
		$message = $this->getColorModifier('ERROR').
			'You don\'t have enough credit. '.$this->product->getName().' costs '.$this->product->getPrice().'.'.PHP_EOL.
			($this->product->getPrice()-$this->availableCredit).' missing'.
			$this->getColorModifier();
		return $message;
	}
}