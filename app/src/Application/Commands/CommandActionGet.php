<?php

namespace App\Application\Commands;

use InvalidArgumentException;
use App\Application\Commands\CommandInterface;
use App\Application\Commands\Command;
use App\Application\Commands\CommandInput;

class CommandActionGet extends Command implements CommandInterface
{

    public function __construct(CommandInput $commandInput)
    {
        parent::__construct($commandInput);
    }

    public function execute(): string
    {
        if($this->isHelpOption()) {
            return $this->getHelpEntry();
        }

        return '';
    }

    public function getHelpEntry(): string
    {
        return 'Usage:'.PHP_EOL.
            '<coin_1>, <coin_2>, ..., GET-WATER'.PHP_EOL; 
    }
}