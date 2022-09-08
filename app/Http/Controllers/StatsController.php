<?php

namespace App\Http\Controllers;


use App\Models\Course;
use App\Models\CourseStart;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Test;
use App\Models\User;

class StatsController extends Controller
{

    public function general_stats() {

        $users = User::count();
        $tests = Test::count();
        $sections = Section::count();
        $lessons = Lesson::count();
        $courses = Course::count();
        $courses_started = CourseStart::count();

        return response()->json(array(
            "users" => $users,
            "tests" => $tests,
            "sections" => $sections,
            "lessons" => $lessons,
            "courses" => $courses,
            "courses_started" => $courses_started
        ), 200);

    }

}
