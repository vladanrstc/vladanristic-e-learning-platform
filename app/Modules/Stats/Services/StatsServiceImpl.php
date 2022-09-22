<?php

namespace App\Modules\Stats\Services;

use App\Models\Course;
use App\Models\CourseStart;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Test;
use App\Models\User;
use JetBrains\PhpStorm\ArrayShape;

class StatsServiceImpl implements IStatsService {

    #[ArrayShape(["users" => "mixed", "tests" => "mixed", "sections" => "mixed", "lessons" => "mixed", "courses" => "mixed", "courses_started" => "mixed"])]
    public function getAppStats(): array
    {
        return [
            "users"           => User::count(),
            "tests"           => Test::count(),
            "sections"        => Section::count(),
            "lessons"         => Lesson::count(),
            "courses"         => Course::count(),
            "courses_started" => CourseStart::count()
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
}
