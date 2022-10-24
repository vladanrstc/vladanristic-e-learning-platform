<?php

namespace App\Modules\Stats\Services;

use App\Enums\LogTypes;
use App\Models\Course;
use App\Models\CourseStart;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Test;
use App\Models\User;
use App\Repositories\ILogsRepo;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class StatsServiceImpl implements IStatsService
{

    /**
     * @var ILogsRepo
     */
    private ILogsRepo $logsRepo;

    public function __construct(ILogsRepo $logsRepo)
    {
        $this->logsRepo = $logsRepo;
    }

    #[ArrayShape([
        "users"               => "mixed",
        "tests"               => "mixed",
        "sections"            => "mixed",
        "lessons"             => "mixed",
        "courses"             => "mixed",
        "latest_user"         => "string",
        "latest_course"       => "string",
        "latest_section"      => "string",
        "latest_lesson"       => "string",
        "latest_test"         => "string",
        "latest_enrollment"   => "string",
        "courses_started"     => "mixed",
        "num_of_monthly_logs" => "array"
    ])]
    public function getAppStats(): array
    {


    }


    /**
     * @return array
     */
    public function getLastThreeVideos(): array
    {

    }

}
