<?php

namespace App\Domain\Services;

use App\Domain\Validators\CoinValidator;
use App\Domain\Exceptions\InvalidCoinException;
use App\Domain\Enum\ValidCoins;

class CashSlot
{
	private $coins = [];
	private $validator;

	public function __construct(array $coins, CoinValidator $validator)
	{
		$this->coins = $coins;
		$this->validator = $validator;
	}

	public function isEmpty(): bool
	{
		return empty($this->coins);
	}

	public function getValidCoins(): array
	{
		return array_diff($this->coins, $this->getInvalidCoins());
	}

	public function getInvalidCoins(): array
	{
		$invalidCoins = [];
		foreach($this->coins as $coin) {
			if(!$this->validator->isValidCoin($coin)) {
				array_push($invalidCoins, $coin);
			}
		}
		return $invalidCoins;
	}

	/**
	 * @return bool True
	 * @throws InvalidCoinException
	 */
	public function validate(): bool
	{
		$invalidCoins = $this->getInvalidCoins();
		if(!empty($invalidCoins)) {
			throw new InvalidCoinException($invalidCoins, ValidCoins::getValidValues());
		}
		
		return true;
	}

}