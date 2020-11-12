<?php

namespace App\Application\Commands;

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
        $response = '';
        return $response;
    }

    public function getHelpEntry(): string
    {
        return 'Gets a product from the machine and returns the change.'.PHP_EOL.PHP_EOL.
                'Usage:'.PHP_EOL.
                '[coin_1], [coin_2], [...], GET-WATER'.PHP_EOL.
                'GET-WATER (if enough credit in the machine)'.PHP_EOL; 
    }
}