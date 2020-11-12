<?php

namespace App\Domain\Services;

/**
 * @todo  This class is meant only for message management pourposes. Methods adding literal messages should be in other class
 */
class Display
{
	private $messages = [];

	public function addMessage(string $message): void
	{
		if(!empty($message)) {
			array_push($this->messages, $message);
		}
	}

	public function flush(): string
	{
		$return = implode(PHP_EOL.PHP_EOL, $this->messages);
		$this->messages = [];
		return $return;
	}

	public function addUserCreditMessage(float $cashTotal): void
	{
		$this->addMessage('Your credit: '.$cashTotal);
	}

	public function addReturnCoinMessage(array $coins): void
	{
		$this->addMessage('Returning coins: '.implode(', ', $coins));
	}

	public function nothingToReturnMessage(): void
	{
		$this->addMessage('No coins to return');
	}
}