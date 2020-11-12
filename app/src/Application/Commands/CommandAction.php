<?php

namespace App\Application\Commands;

use App\Application\Commands\CommandInput;

abstract class CommandAction
{
	private $commandInput;

	public function __construct(CommandInput $commandInput)
	{
		$this->commandInput = $commandInput;
	}
    
    public function getCommandInput(): CommandInput
    {
    	return $this->commandInput;
    }

    public function isHelpOption(): bool
    {
    	return ($this->commandInput->getOption() === CommandInput::HELP_OPTION);
    }
}