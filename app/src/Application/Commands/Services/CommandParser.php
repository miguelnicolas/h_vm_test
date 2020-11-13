<?php

namespace App\Application\Commands\Services;

use App\Application\Commands\Enum\ApiActions;

class CommandParser extends BaseCommandParser
{

	const REGEX_SIMPLE_COMMAND = '/([A-Z\-]+)(?:\s\-\-?([a-z]{0,}))?/i';
	const REGEX_COINS_ARGUMENTS = '/(\d+(?:\.?\d{1,2})*(?:,\s?)?)/';
	const REGEX_SERVICE_ARGUMENTS = '/(?:([A-Z]+|(?:(?:\d+)(?:\.\d{1,2})?))\-(\d{1,2}))+/i';

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

		$this->parseCommandInput();
	}

	private function parseCommandInput()
	{
		$countNumerics = 0;
		foreach($this->arguments as $i => $argument) {
			if(is_numeric($argument)) {
				$countNumerics++;
			}
		}

		// If no keyword and all arguments are numeric, it's a shortcut for INSERT-MONEY
		if(empty($this->keyword) && $countNumerics == count($this->arguments)) {
			$this->keyword = ApiActions::INSERT_MONEY;

		// If a GET instruction, let's see what user wants to get
		} elseif(strpos($this->keyword, ApiActions::GET.'-') === 0) {
			$this->subject = substr($this->keyword, strlen((ApiActions::GET.'-')));
			$this->keyword = ApiActions::GET;

		} elseif($this->keyword == ApiActions::SERVICE) {
			preg_match_all(self::REGEX_SERVICE_ARGUMENTS, implode(', ', $this->arguments), $matches, PREG_SET_ORDER);
			$serviceArguments = array('PRODUCTS' => [], 'COINS' => []);
			foreach($matches as $i => $argument) {
				$argument[2] = intval($argument[2]);
				// Is a coin
				if(is_numeric($argument[1])) {
					array_push($serviceArguments['COINS'], [floatval($argument[1]), $argument[2]]);
				// Is a product
				} else {
					array_push($serviceArguments['PRODUCTS'], [$argument[1], $argument[2]]);
				}
			}
			$this->arguments = $serviceArguments;
		}
	}

	private function sanitizeArguments(array $arguments = []) {
		foreach($arguments as $i => $value) {
			$value = preg_replace('/[\s,]/', '', $value);
			is_numeric($value) && $value = floatval($value);
			$arguments[$i] = $value;
		}
		return $arguments;
	}
}