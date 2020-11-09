<?php

namespace App\Controllers;

class ConsoleController
{
	private $running = false;
	private $inputLine;
	private $factory;

	public function run()
	{
		$this->running = true;
		while ($this->isRunning()) {
	      	$this->output(' > ', false);
		    $this->readLine();
		    if ("QUIT" == $this->inputLine) {
			    $this->stop();
		    } else {
		    	$this->execute();
		    }
		}
	}

	public function execute()
	{
		try {
			// 
		} catch (\Exception $e) {
			$this->output($e->getMessage());
		}
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