<?php

namespace App\Modules\Course\Services;

use App\DTOs\FileDTO;
use App\Models\Course;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\File;

interface ICourseService {
    public function getCourseDetailsByCourseSlug(string $courseSlug): Course|null;
    public function getAllCourses(): Collection|null;
    public function deleteCourse(Course $course): bool;
    public function createCourse(string $courseName, string $courseDescription, FileDTO $courseImage = null, string $lang): Course|bool;
    public function updateCourse(Course $course, string $courseName, string $courseDescription, FileDTO $courseImage = null, string $lang): Course|bool;
}
