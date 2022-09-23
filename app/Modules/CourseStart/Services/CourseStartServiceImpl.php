<?php

namespace App\Modules\CourseStart\Services;

use App\Models\CourseStart;
use App\Repositories\ICoursesRepo;
use App\Repositories\ICourseStartRepo;
use Illuminate\Support\Collection;

class CourseStartServiceImpl implements ICourseStartService {

    /**
     * @var ICourseStartRepo
     */
    private ICourseStartRepo $courseStartRepo;

    /**
     * @var ICoursesRepo
     */
    private ICoursesRepo $coursesRepo;

    public function __construct(ICourseStartRepo $courseStartRepo, ICoursesRepo $coursesRepo) {
        $this->courseStartRepo = $courseStartRepo;
        $this->coursesRepo     = $coursesRepo;
    }

    /**
     * @param string $courseId
     * @param int $userId
     * @return CourseStart
     */
    public function enrollUserToCourse(string $courseId, int $userId): CourseStart
    {
        return $this->courseStartRepo->enrollUserInCourse($courseId, $userId);
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getCoursesUserHasntEnrolledIn(int $userId): Collection
    {
        return $this->coursesRepo->getCoursesUserHasntEnrolledIn($userId);
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getCoursesUserEnrolledIn(int $userId): Collection
    {
        return $this->coursesRepo->getCoursesUserEnrolledIn($userId);
    }
}
