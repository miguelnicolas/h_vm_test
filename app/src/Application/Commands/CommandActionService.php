<?php

namespace App\Application\Commands;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\CommandAction;
use App\Application\Commands\CommandInput;

class CommandActionService extends CommandAction implements CommandInterface
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
                        ->service(
                            $this->getCommandInput()->getArguments()['COINS'], 
                            $this->getCommandInput()->getArguments()['PRODUCTS'])
                        ->status()
                        ->getResponse();
        return $response;
    }

    public function getHelpEntry(): string
    {
        return 'Enables service mode. Machine is open, ready to restock.'.PHP_EOL.
                'Quantities are added to the current stock'.PHP_EOL.PHP_EOL.
                'Usage:'.PHP_EOL.
                ' [product_1]-[qty], [coin_value_1]-[qty], [coin_value_2]-[qty], [...], SERVICE'.PHP_EOL.PHP_EOL. 
                'Examples:'.PHP_EOL.
                ' WATER-10, SODA-15, JUICE-8, 1-20, 0.25-20, 0.10-30, 0.05-30, SERVICE'.PHP_EOL.PHP_EOL.
                ' 0.25-50, 0.10-15, WATER-10, SERVICE'.PHP_EOL; 
    }
}