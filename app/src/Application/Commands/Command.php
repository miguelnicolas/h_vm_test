<?php

namespace App\Application\Commands;

use App\Application\Commands\CommandInput;

abstract class Command
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

    public function execute(): string
    {
    	return '';
    }

    public function isHelpOption(): bool
    {
    	return ($this->commandInput->getSubject() === CommandInput::HELP_OPTION);
    }
}