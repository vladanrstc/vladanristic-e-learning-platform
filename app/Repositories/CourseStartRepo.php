<?php

namespace App\Repositories;

use App\Exceptions\UserUpdateFailedException;
use App\Models\Course;
use App\Models\CourseStart;
use App\Modules\Notes\Exceptions\NotesUpdateFailedException;

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
     * @param array $updateParams
     * @param CourseStart $courseStart
     * @return CourseStart
     * @throws NotesUpdateFailedException
     */
    public function updateCourseStartNote(array $updateParams, CourseStart $courseStart): CourseStart
    {
        if($courseStart->update($updateParams)) {
            return $courseStart;
        }
        throw new NotesUpdateFailedException();
    }
}
