<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LocalLogger implements ILocalLoggerRepo
{

    /**
     * @param  string  $eventMessage
     */
    public function logEvent(string $eventMessage)
    {
        Log::info("EVENT TRIGGER START");
        Log::info("DATE: " . Carbon::now()->toString());
        Log::info("Message: " . $eventMessage);
        Log::info("EVENT TRIGGER END");
    }

}
