<?php

namespace App\Repositories;

use App\DTOs\FileDTO;
use App\Models\Course;
use Illuminate\Support\Collection;

interface ICoursesRepo {
    public function getCourseForSlug(string $courseSlug): Course|null;
    public function getAllCourses(): Collection|null;
    public function deleteCourse(Course $course): bool;
    public function createCourse(string $courseName, string $courseDescription, FileDTO $courseImage, string $lang): Course;
    public function updateCourse(Course $course, string $courseName, string $courseDescription, FileDTO $courseImage = null, string $lang): Course;
    public function getCoursesUserHasntEnrolledIn(int $userId): Collection|null;
    public function getCoursesUserEnrolledIn(int $userId): Collection|null;
}
