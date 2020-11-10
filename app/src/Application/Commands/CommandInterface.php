<?php

namespace App\Application\Commands;

interface CommandInterface
{
    public function execute(): string;
    public function getHelpEntry(): string;
}