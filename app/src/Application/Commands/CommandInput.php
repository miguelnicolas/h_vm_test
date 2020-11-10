<?php

namespace App\Application\Commands;

use App\Application\Commands\Enum\ApiActions;

class CommandInput
{
	const HELP_OPTION = '--help';

	private $inputRaw;
	private $keyword;
	private $subject = null;
	private $arguments = [];

	public function __construct(string $input)
	{
		$this->inputRaw = $input;
		$this->parseInput();
	}

	public function parseInput(): void
	{
		$inputParts = explode(', ',$this->inputRaw);

		// Last part of the command is numeric and command matches a string of coins
		if(is_numeric($inputParts[count($inputParts)-1]) && false != preg_match_all('/(\d+(?:\.?\d{1,2})*(?:,\s?)?)/', $this->inputRaw, $matches)) {
			$this->keyword = ApiActions::INSERT_MONEY;
			$this->arguments = $matches[1];
		// Command has only one part and is a text string
		} elseif(count($inputParts) == 1 && false != preg_match_all('/([A-Z\-]+)([A-Z]+)(?:\s\-\-\bhelp\b)?/', $this->inputRaw))  {
			if(strpos($this->inputRaw, self::HELP_OPTION) !== false) {
				$this->subject = self::HELP_OPTION;
				$this->keyword = trim(str_replace(self::HELP_OPTION, '', $this->inputRaw));
			} else {
				$this->keyword = $this->inputRaw;
			}
		// Everything else
		} else {
			$command = trim(array_pop($inputParts));
			if(ApiActions::isValidValue($command)) {
				$this->keyword = $command;
			} else {
				preg_match_all('/([A-Z]{3,})(?:-([A-Z]+))?/', $command, $matches);
				$this->keyword = $matches[1][0];
				$this->subject = !empty($matches[2][0]) ? $matches[2][0] : null;
			}
			$this->arguments = $inputParts;
		}
		$this->keyword = strtoupper($this->keyword);
		$this->arguments = $this->sanitizeArguments($this->arguments);
	}

	public function getKeyword()
	{
		return $this->keyword;
	}

	public function getSubject()
	{
		return $this->subject;
	}

	public function getArguments()
	{
		return $this->arguments;
	}

	public function getCamelCaseKeyword()
	{
		$keywordParts = explode('-', $this->keyword);
		foreach($keywordParts as $key => $value) {
			$keywordParts[$key] = ucfirst(strtolower($value));
		}
		return implode('', $keywordParts);
	}

	private function sanitizeArguments($arguments) {
		foreach($arguments as $i => $value) {
			$arguments[$i] = preg_replace('/[\s,]/', '', $value);
		}
		return $arguments;
	}
}