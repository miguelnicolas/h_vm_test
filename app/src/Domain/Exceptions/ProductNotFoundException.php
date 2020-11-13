<?php

namespace App\Domain\Exceptions;

use App\Application\Exceptions\BaseException;

class ProductNotFoundException extends BaseException
{
	protected $defaultCode = 404;
	private $productName;
	
	public function __construct(string $productName)
	{
		$this->productName = $productName;
		parent::__construct($this->getErrorMessage());
	}

	public function getErrorMessage()
	{
		$message = $this->getColorModifier('ERROR').
			'Product '.$this->productName.' is not in our catalog'.
			$this->getColorModifier();
		return $message;
	}
}