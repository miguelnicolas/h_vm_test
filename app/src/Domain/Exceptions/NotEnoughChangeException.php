<?php

namespace App\Domain\Exceptions;

use App\Application\Exceptions\BaseException;

class NotEnoughChangeException extends BaseException
{
	protected $defaultCode = 404;
	private $product;
	private $availableCredit;

	public function __construct()
	{
		$this->product = $product;
		$this->availableCredit = $availableCredit;
		parent::__construct($this->getErrorMessage());
	}

	public function getErrorMessage()
	{
		$message = $this->getColorModifier('ERROR').
			'Machine doesn\'t have enough change.'.
			$this->getColorModifier();
		return $message;
	}
}