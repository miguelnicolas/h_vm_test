<?php

namespace App\Application\Commands;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\Command;
use App\Application\Commands\CommandInput;

class CommandActionReturnCoin extends Command implements CommandInterface
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
        return 'Returns all the coins in the money slot.'.PHP_EOL.PHP_EOL.
                'Usage:'.PHP_EOL.
                'RETURN-COIN'.PHP_EOL. 
                '[coin_1], [coin_2], ..., RETURN-COIN'.PHP_EOL; 
    }
}