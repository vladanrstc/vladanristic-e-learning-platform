<?php

namespace App\Modules\Notes\Services;

use App\Models\CourseStart;
use App\Models\Note;

interface INotesService {
    public function getUserNotesForCourse(string $courseSlug, int $userId): CourseStart;
    public function removeCourseStartedNote(CourseStart $courseStart): CourseStart;
}
