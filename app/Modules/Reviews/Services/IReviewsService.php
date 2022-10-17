<?php

namespace App\Modules\Reviews\Services;

use App\Models\CourseStart;
use Illuminate\Support\Collection;

interface IReviewsService
{
    public function removeReview(CourseStart $courseStart): CourseStart;

    public function updateCourseStartReview(
        string $courseSlug,
        string $reviewText,
        string $reviewMark,
        int $userId
    ): CourseStart;

    public function getUserReviewsForCourse(string $courseSlug, int $userId): ?CourseStart;

    public function getCourseReviewMarks(int $courseId): ?Collection;

    public function getCourseReviews(string $courseSlug): ?Collection;

    public function getAllCourseReviews(int $courseId);
}
