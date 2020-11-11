<?php

namespace App\Application\Commands;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\Command;
use App\Application\Commands\CommandInput;
use App\Domain\Services\CashSlot;
use App\Domain\Validators\CoinValidator;

class CommandActionInsertMoney extends Command implements CommandInterface
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

        $cashSlot = new CashSlot($this->getCommandInput()->getArguments(), new CoinValidator());
        $response = App()
                        ->insertMoney($cashSlot)
                        ->getResponse();
        return $response;
    }

    public function getHelpEntry(): string
    {
        return 'Inserts coins in the money slot.'.PHP_EOL.PHP_EOL.
                'Usage:'.PHP_EOL.
                '[coin_1], [coin_2], [...]'.PHP_EOL.
                '[coin_1], [coin_2], [...], INSERT-COIN'.PHP_EOL; 
    }
}