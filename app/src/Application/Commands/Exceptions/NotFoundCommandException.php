<?php

namespace App\Application\Commands\Exceptions;

use App\Application\Exceptions\BaseException;
use App\Application\Commands\CommandInput;
use App\Application\Commands\Enum\ApiActions;

class NotFoundCommandException extends BaseException
{
	protected $defaultCode = 404;
	private $commandInput;

	public function __construct(CommandInput $commandInput)
	{
		$this->commandInput = $commandInput;

		parent::__construct($this->getErrorMessage());
	}

	public function getErrorMessage()
	{
		return  $this->getColorModifier('ERROR').
				'Command ['.$this->commandInput->getKeyword().'] not found.'.
				$this->getColorModifier().PHP_EOL.
				'Available commands:'.PHP_EOL.' '.implode(PHP_EOL.' ', ApiActions::getValidValues()).PHP_EOL.PHP_EOL.
				'If you need help on how to use them, type the command name followed by --help'.PHP_EOL.
				'Example:'.PHP_EOL.
				' SERVICE --help'.PHP_EOL;
	}

}