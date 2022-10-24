<?php

namespace App\Modules\Stats\Command;

use App\Enums\LogTypes;
use App\Models\Course;
use App\Models\CourseStart;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Test;
use App\Models\User;
use App\Repositories\ILogsRepo;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class OverallStatusCommand extends StatsCommand
{

    /**
     * @var ILogsRepo
     */
    private ILogsRepo $logsRepo;

    public function __construct(array $params, ILogsRepo $logsRepo)
    {
        parent::__construct($params);
        $this->logsRepo = $logsRepo;
    }

    public function execute()
    {
        $numOfLogsPerMonth = [
            'Jan' => 0,
            'Feb' => 0,
            'Mar' => 0,
            'Apr' => 0,
            'May' => 0,
            'Jun' => 0,
            'Jul' => 0,
            'Avg' => 0,
            'Sep' => 0,
            'Oct' => 0,
            'Nov' => 0,
            'Dec' => 0
        ];

        $logs = $this->logsRepo->getYearLogsPerTypeForPastYear(LogTypes::USER_LOGGED_IN->value)?->countBy(function ($log
        ) {
            return Carbon::parse($log->created_at)->format('M');
        })->toArray();

        try {
            $this->status = 200;
            return [
                "users"               => User::count(),
                "tests"               => Test::count(),
                "sections"            => Section::count(),
                "lessons"             => Lesson::count(),
                "courses"             => Course::count(),
                "courses_started"     => CourseStart::count(),
                "latest_user"         => $this->formatStatOutput(
                    User::orderBy("created_at", "DESC")->first()?->only([
                        User::name(), User::lastName()
                    ])),
                "latest_course"       => $this->formatStatOutput(array(
                    Course::orderBy("created_at", "DESC")->first()?->getTranslation(Course::courseName(), "sr")
                )),
                "latest_section"      => $this->formatStatOutput(
                    Section::orderBy(
                        "created_at",
                        "DESC")->first()?->only([Section::sectionName()])),
                "latest_lesson"       => $this->formatStatOutput(
                    Lesson::orderBy(
                        "created_at",
                        "DESC")->first()?->only([Lesson::lessonTitle()])),
                "latest_test"         => $this->formatStatOutput(array(
                    Test::orderBy("created_at", "DESC")->first()?->getTranslation(Test::testName(), "sr")
                )),
                "latest_enrollment"   => CourseStart::orderBy("created_at", "DESC")->limit(1)->get()?->map(function (
                    CourseStart $enrollement
                ) {
                    return $this->formatStatOutput(
                            $enrollement->user()->first()->only([User::name(), User::lastName()]))
                        . ", " .
                        $this->formatStatOutput($enrollement->course()->first()->only([Course::courseName()]));
                })[0],
                "num_of_monthly_logs" => array_values(array_merge($numOfLogsPerMonth, $logs))
            ];
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            $this->status = 500;
        }

    }

    /**
     * @param  array  $values
     * @return string
     */
    private function formatStatOutput(array $values)
    {
        return implode(" ", array_values($values));
    }
}
