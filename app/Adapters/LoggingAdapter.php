<?php

namespace App\Adapters;

use App\Models\Log;
use App\Repositories\ILogsRepo;
use App\Repositories\LocalLogger;
use App\Repositories\LogsRepo;
use Illuminate\Support\Collection;

class LoggingAdapter implements ILogsRepo
{

    /**
     * @var LocalLogger
     */
    private LocalLogger $localLogger;

    /**
     * @var LogsRepo
     */
    private LogsRepo $logsRepo;

    public function __construct()
    {
        $this->localLogger = new LocalLogger();
        $this->logsRepo    = new LogsRepo();
    }

    public function insertLog(array $logParams): Log
    {
        $this->localLogger->logEvent(array_values($logParams)[0]);
        return $this->logsRepo->insertLog($logParams);
    }

    public function getYearLogsPerTypeForPastYear(string $logType): ?Collection
    {
        return $this->logsRepo->getYearLogsPerTypeForPastYear($logType);
    }
}
