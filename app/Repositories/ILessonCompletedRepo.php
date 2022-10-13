<?php

namespace App\Repositories;

use App\Models\LessonCompleted;

interface ILessonCompletedRepo
{
    public function addCompletedLesson(int $lessonId, int $userCourseStartedId): LessonCompleted;
}
