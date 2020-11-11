<?php

namespace App\Application\Commands\Services;

class CommandParser extends BaseCommandParser
{

	const REGEX_SIMPLE_COMMAND = '/([A-Z\-]+)(?:\s\-\-?([a-z]{0,}))?/i';
	const REGEX_COINS_ARGUMENTS = '/(\d+(?:\.?\d{1,2})*(?:,\s?)?)/';

	public function breakDownInput(string $inputLine): void
	{
		$this->inputRaw = $inputLine;
		
		$inputParts = explode(', ',$this->inputRaw);

		// Last part of the command is numeric and command matches a string of coins
		if(is_numeric($inputParts[count($inputParts)-1]) && false != preg_match_all(self::REGEX_COINS_ARGUMENTS, $this->inputRaw, $matches)) {
			$this->arguments = $matches[1];

		// Command has only one part and is a text string
		} elseif(count($inputParts) == 1 && false != preg_match_all(self::REGEX_SIMPLE_COMMAND, $this->inputRaw, $matches))  {
			$this->keyword = $matches[1][0];
			!empty($matches[2][0]) && $this->option = $matches[2][0];
			
		// Everything else
		} else {
			$command = trim(array_pop($inputParts));
			$this->keyword = $command;
			$this->arguments = $inputParts;
		}
		$this->keyword && $this->keyword = strtoupper($this->keyword);
		$this->arguments = $this->sanitizeArguments($this->arguments);
	}

	private function sanitizeArguments($arguments) {
		foreach($arguments as $i => $value) {
			$value = preg_replace('/[\s,]/', '', $value);
			is_numeric($value) && $value = floatval($value);
			$arguments[$i] = $value;
		}
		return $arguments;
	}
}