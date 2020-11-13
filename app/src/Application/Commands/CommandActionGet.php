<?php

namespace App\Application\Commands;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\CommandAction;
use App\Application\Commands\CommandInput;
use App\Domain\Enum\ValidCoins;
use App\Domain\Services\CashSlot;
use App\Domain\Services\ChangeDispenser;
use App\Domain\Validators\CoinValidator;
use App\Domain\Validators\ProductValidator;

class CommandActionGet extends CommandAction implements CommandInterface
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
                        ->insertMoney($this->getCommandInput()->getArguments()) // User could have inserted some coins in the same command
                        ->getProduct($this->getCommandInput()->getSubject()/*, $productDispenser*/) // Get product
                        ->getResponse(); // Get response to show to user
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