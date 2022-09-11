<?php

namespace App\Modules\Course\Services;

use App\Models\Course;
use Illuminate\Support\Collection;

interface ICourseService {
    public function getCourseDetailsByCourseSlug(string $courseSlug): Course;
    public function getAllCourses(): Collection;
    public function deleteCourse(Course $course): bool;
}
