<?php

namespace App\Modules\Stats\Command;

interface ICommandManager
{
    public function getCommand(string $commandName, array $commandParams): StatsCommand;
}
