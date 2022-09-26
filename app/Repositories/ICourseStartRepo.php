<?php

namespace App\Repositories;

use App\Models\CourseStart;
use Illuminate\Support\Collection;

interface ICourseStartRepo {
    public function getCourseStartForCourseAndUser(string $courseSlug, int $userId): CourseStart|null;
    public function updateCourseStart(array $updateParams, CourseStart $courseStart): CourseStart;
    public function getCourseNotes($courseId): CourseStart|null;
    public function getCourseReviewMarks($courseId): Collection|null;
    public function getCourseReviews(string $courseSlug): Collection|null;
    public function enrollUserInCourse(string $courseId, string $userId): CourseStart;
    public function getCourseStartedForUserAndLessonId(int $lessonId, int $userId): CourseStart|null;
}
