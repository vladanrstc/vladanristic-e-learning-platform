<?php

namespace App\Modules\Notes\Services;

use App\Models\CourseStart;

interface INotesService
{
    public function getUserNotesForCourse(string $courseSlug, int $userId): CourseStart|null;

    public function removeCourseStartedNote(CourseStart $courseStart): CourseStart;

    public function updateUserCourseStartedNotes(string $courseSlug, string $notes, int $userId): CourseStart;

    public function getNotesForCourse(string $courseId);
}
