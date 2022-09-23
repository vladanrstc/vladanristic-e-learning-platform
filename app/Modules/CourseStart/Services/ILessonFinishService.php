<?php

namespace App\Modules\CourseStart\Services;

use App\Models\LessonCompleted;

interface ILessonFinishService {
    public function completeLesson(int $lessonId, int $userId): LessonCompleted;
}
