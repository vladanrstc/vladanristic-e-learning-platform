<?php

namespace App\Modules\Course\Services;

use App\Models\Course;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\File;

interface ICourseService {
    public function getCourseDetailsByCourseSlug(string $courseSlug): Course;
    public function getAllCourses(): Collection;
    public function deleteCourse(Course $course): bool;
    public function createCourse(string $courseName, string $courseDescription, File $courseImage = null, string $lang): Course|bool;
    public function updateCourse(Course $course, string $courseName, string $courseDescription, File $courseImage = null, string $lang): Course|bool;
}
