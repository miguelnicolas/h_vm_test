<?php

namespace App\Interfaces;

use App\Application\Commands\CommandInput;
use App\Application\Commands\CommandFactory;
use App\Application\Commands\Enum\ApiActions;

class Console
{
	private $running = false;
	private $inputLine;

	public function run()
	{
		$this->running = true;
		while ($this->isRunning()) {
	      	$this->output(' > ', false);
		    $this->readLine();
		    if (ApiActions::EXIT == strtoupper($this->inputLine)) {
			    $this->stop();
		    } else {
		    	$response = $this->execute();
		    	$this->output($response);
		    }
		}
	}

	public function execute()
	{
		try {
			$commandInput = new CommandInput($this->inputLine);
			$response = CommandFactory::getCommandFromInput($commandInput)->execute();
		} catch (\Exception $e) {
			$this->output($e->getMessage());
		}

		return $response;
	}

	public function readLine($inputLine = null)
	{
		is_null($inputLine) && $inputLine = fgets(STDIN);  // by default, read the special file to get the user input from keyboard
		$this->inputLine = trim($inputLine, PHP_EOL);
	}

	public function output(string $output, bool $breakline = true): void
	{
		$breakline && $output.= PHP_EOL;
		print($output);
	}

	private function stop(): void
	{
		$this->running = false;
		$this->output('Bye bye!');
	}

	private function isRunning(): bool
	{
		return $this->running;
	}

}