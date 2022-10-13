<?php

namespace App\Repositories;

use App\Models\Log;
use Illuminate\Support\Collection;

interface ILogsRepo
{
    public function insertLog(array $logParams): Log;

    public function getYearLogsPerTypeForPastYear(string $logType): ?Collection;
}
