<?php

namespace App\Modules\CourseStart\Services;

use App\Models\CourseStart;
use Illuminate\Support\Collection;

interface ICourseStartService {
    public function enrollUserToCourse(string $courseId, int $userId): CourseStart;
    public function getCoursesUserHasntEnrolledIn(int $userId): Collection;
    public function getCoursesUserEnrolledIn(int $userId): Collection;
}
