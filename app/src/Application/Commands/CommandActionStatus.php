<?php

namespace App\Application\Commands;

use App\Application\Commands\CommandInterface;
use App\Application\Commands\CommandAction;
use App\Application\Commands\CommandInput;

class CommandActionStatus extends CommandAction implements CommandInterface
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
                        ->status()
                        ->getResponse();
        return $response;
    }

    public function getHelpEntry(): string
    {
        return 'Displays the Machine\'s status.'.PHP_EOL.PHP_EOL.
                'Usage:'.PHP_EOL.
                ' STATUS'.PHP_EOL; 
    }
}