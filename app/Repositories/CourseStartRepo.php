<?php

namespace App\Repositories;

use App\Exceptions\CourseStartUpdateFailedException;
use App\Models\Course;
use App\Models\CourseStart;
use Illuminate\Support\Collection;

class CourseStartRepo implements ICourseStartRepo {

    /**
     * @param string $courseSlug
     * @param int $userId
     * @return CourseStart
     */
    public function getCourseStartForCourseAndUser(string $courseSlug, int $userId): CourseStart
    {
        return CourseStart::whereHas("course", function($query) use ($courseSlug) {
            $query->where(Course::courseSlug(), $courseSlug);
        })
            ->where(CourseStart::userId(), $userId)
            ->first();
    }

    /**
     * @param $courseId
     * @return mixed
     */
    public function getCourseNotes($courseId): mixed
    {
        return CourseStart::where(CourseStart::courseId(), $courseId)
            ->whereNotNull(CourseStart::courseStartNote())
            ->with('user')
            ->paginate(10);
    }

    /**
     * @param array $updateParams
     * @param CourseStart $courseStart
     * @return CourseStart
     * @throws CourseStartUpdateFailedException
     */
    public function updateCourseStart(array $updateParams, CourseStart $courseStart): CourseStart
    {
        if($courseStart->update($updateParams)) {
            return $courseStart;
        }
        throw new CourseStartUpdateFailedException();
    }

    /**
     * @param $courseId
     * @return mixed
     */
    public function getCourseReviewMarks($courseId): Collection
    {
        return CourseStart::where(CourseStart::courseId(), $courseId)
            ->whereNotNull(CourseStart::courseStartMark())
            ->with('user')
            ->get();
    }

    /**
     * @param $courseId
     * @return Collection
     */
    public function getCourseReviews($courseId): Collection
    {
        return CourseStart::where(CourseStart::courseId(), $courseId)
            ->whereNotNull(CourseStart::courseStartReview())
            ->whereNotNull(CourseStart::courseStartMark())
            ->with('user')
            ->get();
    }
}
