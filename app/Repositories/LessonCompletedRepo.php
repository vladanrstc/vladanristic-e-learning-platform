<?php

namespace App\Repositories;

use App\Models\LessonCompleted;

class LessonCompletedRepo implements ILessonCompletedRepo
{

    /**
     * @param  int  $lessonId
     * @param  int  $userCourseStartedId
     * @return LessonCompleted
     */
    public function addCompletedLesson(int $lessonId, int $userCourseStartedId): LessonCompleted
    {
        return LessonCompleted::create([
            "lesson_completed_flag" => true,
            "lesson_id"             => $lessonId,
            "course_started_id"     => $userCourseStartedId,
        ]);
    }
}
