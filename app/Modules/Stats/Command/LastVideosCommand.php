<?php

namespace App\Modules\Stats\Command;

use App\Models\Lesson;
use Exception;
use Illuminate\Support\Facades\Log;

class LastVideosCommand extends StatsCommand
{

    public function execute()
    {
        try {
            $this->status = 200;
            return Lesson::orderBy("created_at", "desc")
                ->whereNotNull("lesson_video_link")
                ->take(3)
                ->get()->toArray();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            $this->status = 500;
        }
    }
}
