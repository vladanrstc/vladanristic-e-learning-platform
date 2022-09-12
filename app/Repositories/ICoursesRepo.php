<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Support\Collection;

interface ICoursesRepo {
    public function getCourseForSlug(string $courseSlug): Course|null;
    public function getAllCourses(): Collection;
    public function deleteCourse(Course $course): bool;
    public function createCourse(string $courseName, string $courseDescription, $courseImage, string $lang): Course;
}
