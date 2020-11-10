<?php

namespace App\Application\Commands\Exceptions;

use App\Application\Exceptions\BaseException;
use App\Application\Commands\CommandInput;
use App\Enums\ApiActions;

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
		print_r($this->commandInput);
		return 'Command ['.$this->commandInput->getKeyword().'] not found. Available commands:'.PHP_EOL.implode(PHP_EOL, ApiActions::getValidValues());
	}
}