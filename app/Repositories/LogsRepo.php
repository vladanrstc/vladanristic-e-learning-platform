<?php

namespace App\Repositories;

use App\Models\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class LogsRepo implements ILogsRepo
{

    /**
     * @param array $logParams
     * @return Log
     */
    public function insertLog(array $logParams): Log
    {
        return Log::create($logParams);
    }

    /**
     * @param string $logType
     * @return Collection|null
     */
    public function getYearLogsPerTypeForPastYear(string $logType): ?Collection
    {
        return Log::where(Log::logType(), $logType)
            ->where("created_at", '>', Carbon::now()->subMonths(12))
            ->get();
    }
}
