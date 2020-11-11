<?php

namespace App\Application\Commands;

use App\Application\Commands\Services\BaseCommandParser;
use App\Application\Commands\Enum\ApiActions;
use App\Application\Commands\Exceptions\NotFoundCommandException;

class CommandInput
{
	const HELP_OPTION = 'help';

	private $keyword;
	private $subject;
	private $arguments;
	private $option;

	public function __construct(BaseCommandParser $commandParser, string $inputLine)
	{
		$commandParser->breakDownInput($inputLine);
		$this->keyword = $commandParser->getKeyword();
		$this->subject = $commandParser->getSubject();
		$this->arguments = $commandParser->getArguments();
		$this->option = $commandParser->getOption();

		$this->parseCommandInput();

		if(!$this->isValidCommand($this->keyword)) {
			throw new NotFoundCommandException($this);
		}
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
		}
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

	public function getOption()
	{
		return $this->option;
	}

	public function getCamelCaseKeyword()
	{
		$keywordParts = explode('-', $this->keyword);
		foreach($keywordParts as $key => $value) {
			$keywordParts[$key] = ucfirst(strtolower($value));
		}
		return implode('', $keywordParts);
	}

	private function isValidCommand($command)
	{
		return ApiActions::isValidValue($command);
	}
}