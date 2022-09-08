<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseStart;
use App\Models\Lesson;
use App\Models\LessonCompleted;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class LessonCompletedController extends Controller
{

    public function finish_lesson(Lesson $lesson) {

        $section = Section::where("section_id", $lesson->lesson_section_id)->first();
        $course = Course::where("course_id", $section->section_course_id)->first();
        $course_started = CourseStart::where("course_id", $course->course_id)
            ->where("user_id", Auth::id())
            ->first();
        $lesson_completed = LessonCompleted::create([
            "lesson_completed_flag" => true,
            "lesson_id" => $lesson->lesson_id,
            "course_started_id" => $course_started->user_course_started_id,
        ]);

        $lesson_completed->save();

        return $lesson_completed;
    }

}
