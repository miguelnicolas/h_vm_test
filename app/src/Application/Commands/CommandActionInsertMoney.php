<?php

namespace App\Application\Commands;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\CommandAction;
use App\Application\Commands\CommandInput;
use App\Domain\Services\CashSlot;
use App\Domain\Validators\CoinValidator;

class CommandActionInsertMoney extends CommandAction implements CommandInterface
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
        $response = App()
                        ->insertMoney($this->getCommandInput()->getArguments()) // User inserted coins
                        ->credit() // Calculates the credit
                        ->getResponse(); // Get response to show to user
        return $response;
    }

    public function getHelpEntry(): string
    {
        return 'Inserts coins in the money slot.'.PHP_EOL.PHP_EOL.
                'Usage:'.PHP_EOL.
                ' [coin_1], [coin_2], [...]'.PHP_EOL.
                ' [coin_1], [coin_2], [...], INSERT-COIN'.PHP_EOL; 
    }
}