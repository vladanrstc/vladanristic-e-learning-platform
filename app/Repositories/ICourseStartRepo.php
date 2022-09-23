<?php

namespace App\Repositories;

use App\Models\CourseStart;

interface ICourseStartRepo {
    public function getCourseStartForCourseAndUser(string $courseSlug, int $userId): CourseStart;
    public function updateCourseStartNote(array $updateParams, CourseStart $courseStart): CourseStart;
    public function getCourseNotes($courseId);
}
