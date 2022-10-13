<?php

namespace App\Repositories;

use App\Exceptions\CourseStartUpdateFailedException;
use App\Models\Course;
use App\Models\CourseStart;
use App\Models\Lesson;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CourseStartRepo implements ICourseStartRepo
{

    /**
     * @param  string  $courseSlug
     * @param  int  $userId
     * @return CourseStart|null
     */
    public function getCourseStartForCourseAndUser(string $courseSlug, int $userId): CourseStart|null
    {
        return CourseStart::whereHas("course", function ($query) use ($courseSlug) {
            $query->where(Course::courseSlug(), $courseSlug);
        })
            ->where(CourseStart::userId(), $userId)
            ->first();
    }

    /**
     * @param $courseId
     * @return CourseStart|null
     */
    public function getCourseNotes($courseId): CourseStart|null
    {
        return CourseStart::where(CourseStart::courseId(), $courseId)
            ->whereNotNull(CourseStart::courseStartNote())
            ->with('user')
            ->paginate(10);
    }

    /**
     * @param  array  $updateParams
     * @param  CourseStart  $courseStart
     * @return CourseStart
     * @throws CourseStartUpdateFailedException
     */
    public function updateCourseStart(array $updateParams, CourseStart $courseStart): CourseStart
    {
        if ($courseStart->update($updateParams)) {
            return $courseStart;
        }
        throw new CourseStartUpdateFailedException();
    }

    /**
     * @param $courseId
     * @return Collection|null
     */
    public function getCourseReviewMarks($courseId): Collection|null
    {
        return CourseStart::where(CourseStart::courseId(), $courseId)
            ->whereNotNull(CourseStart::courseStartMark())
            ->with('user')
            ->get();
    }

    /**
     * @param  string  $courseSlug
     * @return Collection|null
     */
    public function getCourseReviews(string $courseSlug): Collection|null
    {
        return CourseStart::whereHas("course", function ($query) use ($courseSlug) {
            $query->where(Course::courseSlug(), $courseSlug);
        })
            ->whereNotNull(CourseStart::courseStartReview())
            ->whereNotNull(CourseStart::courseStartMark())
            ->with('user')
            ->get();
    }

    /**
     * @param  string  $courseId
     * @param  string  $userId
     * @return CourseStart
     */
    public function enrollUserInCourse(string $courseId, string $userId): CourseStart
    {
        $courseStarted                            = new CourseStart();
        $courseStarted->{CourseStart::courseId()} = $courseId;
        $courseStarted->{CourseStart::userId()}   = $userId;
        $courseStarted->save();
        return $courseStarted;
    }

    /**
     * @param  int  $courseId
     * @param  int  $userId
     * @return CourseStart|null
     */
    public function getCourseStartedForUserIdAndCourse(int $courseId, int $userId): CourseStart|null
    {
        return CourseStart::where(Course::courseId(), $courseId)
            ->where(CourseStart::userId(), Auth::id())
            ->first();
    }

    /**
     * @param  int  $lessonId
     * @param  int  $userId
     * @return CourseStart|null
     */
    public function getCourseStartedForUserAndLessonId(int $lessonId, int $userId): ?CourseStart
    {
        return CourseStart::where(CourseStart::userId(), $userId)
            ->whereHas("course.sections.lessons", function ($query) use ($lessonId) {
                $query->where(Lesson::lessonId(), $lessonId);
            })->first();
    }

    /**
     * @param  int  $courseStartedId
     * @return CourseStart|null
     */
    public function getCourseStartedById(int $courseStartedId): ?CourseStart
    {
        return CourseStart::where(CourseStart::courseStartedId(), $courseStartedId)->first();
    }
}
