<?php

namespace App\Modules\Reviews\Services;

use App\Models\CourseStart;
use App\Repositories\ICourseStartRepo;
use Illuminate\Support\Collection;

class ReviewsServiceImpl implements IReviewsService
{

    /**
     * @var ICourseStartRepo
     */
    private ICourseStartRepo $courseStartRepo;

    public function __construct(ICourseStartRepo $courseStartRepo)
    {
        $this->courseStartRepo = $courseStartRepo;
    }

    /**
     * @param  string  $courseSlug
     * @param  string  $reviewText
     * @param  string  $reviewMark
     * @param  int  $userId
     * @return CourseStart
     */
    public function updateCourseStartReview(
        string $courseSlug,
        string $reviewText,
        string $reviewMark,
        int $userId
    ): CourseStart {
        return $this->courseStartRepo->updateCourseStart([
            CourseStart::courseStartMark() => $reviewMark,
            CourseStart::courseStartReview() => $reviewText
        ], $this->courseStartRepo->getCourseStartForCourseAndUser($courseSlug, $userId));
    }

    /**
     * @param  string  $courseSlug
     * @param  int  $userId
     * @return CourseStart|null
     */
    public function getUserReviewsForCourse(string $courseSlug, int $userId): CourseStart|null
    {
        return $this->courseStartRepo->getCourseStartForCourseAndUser($courseSlug, $userId);
    }

    /**
     * @param  CourseStart  $courseStart
     * @return CourseStart
     */
    public function removeReview(CourseStart $courseStart): CourseStart
    {
        return $this->courseStartRepo->updateCourseStart([
            CourseStart::courseStartReview() => null,
            CourseStart::courseStartMark() => null
        ], $courseStart);
    }

    /**
     * @param  int  $courseId
     * @return Collection|null
     */
    public function getCourseReviewMarks(int $courseId): Collection|null
    {
        return $this->courseStartRepo->getCourseReviewMarks($courseId);
    }

    /**
     * @param  string  $courseSlug
     * @return Collection|null
     */
    public function getCourseReviews(string $courseSlug): Collection|null
    {
        return $this->courseStartRepo->getCourseReviews($courseSlug);
    }
}
