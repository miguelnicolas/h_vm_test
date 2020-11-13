<?php

namespace App\Domain\Exceptions;

use App\Application\Exceptions\BaseException;

class ProductNoStockException extends BaseException
{
	protected $defaultCode = 400;
	private $productName;

	public function __construct(string $productName)
	{
		$this->productName = $productName;
		parent::__construct($this->getErrorMessage());
	}

	public function getErrorMessage()
	{
		$message = $this->getColorModifier('ERROR').
			'There is no stock of '.$this->productName.'. Please, select another product'.
			$this->getColorModifier();
		return $message;
	}
}