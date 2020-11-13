<?php

namespace App\Domain\Services;

/**
 * @todo This class is meant only for message management pourposes. Methods adding literal messages should be in other class
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

	public function addSummaryMessage(array $items, string $header = ''): void
	{
		$this->addMessage($header.PHP_EOL.$this->getGroupedValuesMessageSummary($items));
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

	public function notEnoughChange(): void
	{
		$this->addMessage('Machine doesn\'t have enough change.');
	}

	public function productWithChangeMessage(string $productName, array $coins): void
	{
		$this->addMessage($productName.', '.implode(', ', $coins));
	}

	private function getGroupedValuesMessageSummary($items): string
	{
		$values = [];
		foreach($items as $item) {
			$item = strval($item);
			if(!array_key_exists($item, $values)) {
				$values[$item] = 0;
			}
			$values[$item]++;
		}
		$messageDetail = '';
		foreach($values as $item => $qty) {
			$messageDetail.= " $item\t => $qty".PHP_EOL;
		}
		return $messageDetail;
	}
}