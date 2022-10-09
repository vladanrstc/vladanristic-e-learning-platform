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

class StatsServiceImpl implements IStatsService {

    /**
     * @var ILogsRepo
     */
    private ILogsRepo $logsRepo;

    public function __construct(ILogsRepo $logsRepo) {
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

        $logs = $this->logsRepo->getYearLogsPerTypeForPastYear(LogTypes::USER_LOGGED_IN->value)?->countBy(function($log) {
            return Carbon::parse($log->created_at)->format('M');
        })->toArray();

        return [
            "users"               => User::count(),
            "tests"               => Test::count(),
            "sections"            => Section::count(),
            "lessons"             => Lesson::count(),
            "courses"             => Course::count(),
            "courses_started"     => CourseStart::count(),
            "latest_user"         => $this->formatStatOutput(User::orderBy("created_at", "DESC")->first()?->only([User::name(), User::lastName()])),
            "latest_course"       => $this->formatStatOutput(array(Course::orderBy("created_at", "DESC")->first()?->getTranslation(Course::courseName(), "sr"))),
            "latest_section"      => $this->formatStatOutput(Section::orderBy("created_at", "DESC")->first()?->only([Section::sectionName()])),
            "latest_lesson"       => $this->formatStatOutput(Lesson::orderBy("created_at", "DESC")->first()?->only([Lesson::lessonTitle()])),
            "latest_test"         => $this->formatStatOutput(array(Test::orderBy("created_at", "DESC")->first()?->getTranslation(Test::testName(), "sr"))),
            "latest_enrollment"   => CourseStart::orderBy("created_at", "DESC")->limit(1)->get()?->map(function(CourseStart $enrollement) {
                return $this->formatStatOutput($enrollement->user()->first()->only([User::name(), User::lastName()]))
                    . ", " .
                    $this->formatStatOutput($enrollement->course()->first()->only([Course::courseName()]));
            })[0],
            "num_of_monthly_logs" => array_values(array_merge($numOfLogsPerMonth, $logs))
        ];
    }

    /**
     * @return array
     */
    public function getLastThreeVideos(): array
    {
        return Lesson::orderBy("created_at", "desc")
            ->whereNotNull("lesson_video_link")
            ->take(3)
            ->get()->toArray();
    }

    /**
     * @param array $values
     * @return string
     */
    private function formatStatOutput(array $values) {
        return implode(" ", array_values($values));
    }

}
