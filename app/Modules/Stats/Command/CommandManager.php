<?php

namespace App\Modules\Stats\Command;

use App\Repositories\LogsRepo;
use Exception;

class CommandManager implements ICommandManager
{

    /**
     * @throws Exception
     */
    public function getCommand(string $commandName, array $commandParams): StatsCommand
    {
        return match ($commandName) {
            "overall-status" => new OverallStatusCommand($commandParams, new LogsRepo()),
            "last-three-videos" => new LastVideosCommand($commandParams),
            default => throw new Exception("Unknown command given!"),
        };
    }

}
