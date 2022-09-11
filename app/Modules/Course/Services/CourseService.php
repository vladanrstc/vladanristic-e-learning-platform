<?php

namespace App\Modules\Course\Services;

use App\Models\Course;
use App\Modules\Course\Exceptions\CourseNotFoundException;
use App\Repositories\CoursesRepo;
use App\Repositories\ICoursesRepo;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CourseService implements ICourseService
{

    /**
     * @var ICoursesRepo
     */
    private ICoursesRepo $coursesRepo;

    /**
     * @param CoursesRepo $coursesRepo
     */
    public function __construct(CoursesRepo $coursesRepo) {
        $this->coursesRepo = $coursesRepo;
    }

    /**
     * @param string $courseSlug
     * @return Course
     * @throws CourseNotFoundException
     */
    public function getCourseDetailsByCourseSlug(string $courseSlug): Course
    {
        if(!is_null($course = $this->coursesRepo->getCourseForSlug($courseSlug))) {
            return $course;
        }
        throw new CourseNotFoundException();
    }

    /**
     * @return Collection
     */
    public function getAllCourses(): Collection
    {
        return $this->coursesRepo->getAllCourses();
    }

    /**
     * @param Course $course
     * @return bool
     */
    public function deleteCourse(Course $course): bool
    {
        try {
            return $this->coursesRepo->deleteCourse($course);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return false;
        }
    }
}