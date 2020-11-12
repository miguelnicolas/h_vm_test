<?php

namespace App\Application\Commands;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\Command;
use App\Application\Commands\CommandInput;
use App\Domain\Services\CashSlot;
use App\Domain\Validators\CoinValidator;

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
        
        $cashSlot = new CashSlot($this->getCommandInput()->getArguments(), 
                                 new CoinValidator);
        $response = App()
                        ->insertMoney($cashSlot) // User could have inserted some coins in the same command
                        ->returnCoin() // Return all cash inserted by user
                        ->getResponse(); // Get response to show to user
        return $response;
    }

    public function getHelpEntry(): string
    {
        return 'Returns all the coins in the money slot.'.PHP_EOL.PHP_EOL.
                'Usage:'.PHP_EOL.
                ' RETURN-COIN'.PHP_EOL; 
    }
}