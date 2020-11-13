<?php

namespace App\Application\Commands\Services;

abstract class BaseCommandParser
{
	protected $inputRaw;
	protected $keyword = null;
	protected $subject = null;
	protected $arguments = [];
	protected $option = null;

	public function getKeyword(): ?string
	{
		return $this->keyword;
	}

	public function getSubject(): ?string
	{
		return $this->subject;
	}

	public function getArguments(): ?array
	{
		return $this->arguments;
	}

	public function getOption(): ?string
	{
		return $this->option;
	}

	abstract public function breakDownInput(string $inputRaw): void;
}