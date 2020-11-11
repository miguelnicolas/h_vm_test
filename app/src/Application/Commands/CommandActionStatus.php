<?php

namespace App\Application\Commands;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\Command;
use App\Application\Commands\CommandInput;

class CommandActionStatus extends Command implements CommandInterface
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
        $response = '';
        return $response;
    }

    public function getHelpEntry(): string
    {
        return 'Displays the Machine\'s status.'.PHP_EOL.PHP_EOL.
                'Usage:'.PHP_EOL.
                'STATUS'.PHP_EOL; 
    }
}