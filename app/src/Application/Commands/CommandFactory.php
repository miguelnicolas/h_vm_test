<?php

namespace App\Application\Commands;

use App\Application\Commands\CommandInput;
use App\Application\Commands\Exceptions;

class CommandFactory
{
	/**
	 * @param  CommandInput $commandInput [description]
	 * @return CommandAction
	 */
	public static function getCommandFromInput(CommandInput $commandInput): CommandInterface
	{
		$commandActionName = 'App\\Application\\Commands\\CommandAction'.$commandInput->getCamelCaseKeyword();
		
		if(!class_exists($commandActionName)) {
			throw new Exceptions\NotFoundCommandException($commandInput);
		}
		$commandAction = new $commandActionName($commandInput);

		return $commandAction;
	}
}