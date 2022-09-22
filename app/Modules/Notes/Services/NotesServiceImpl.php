<?php

namespace App\Modules\Notes\Services;

use App\Models\CourseStart;
use App\Models\Note;
use App\Repositories\ICourseStartRepo;

class NotesServiceImpl implements INotesService {

    /**
     * @var ICourseStartRepo
     */
    private ICourseStartRepo $courseStartRepo;

    /**
     * @param ICourseStartRepo $courseStartRepo
     */
    public function __construct(ICourseStartRepo $courseStartRepo) {
        $this->courseStartRepo = $courseStartRepo;
    }

    /**
     * @param string $courseSlug
     * @param int $userId
     * @return array
     */
    public function getUserNotesForCourse(string $courseSlug, int $userId): CourseStart
    {
        return $this->courseStartRepo->getCourseStartForCourseAndUser($courseSlug, $userId);
    }

    /**
     * @param CourseStart $courseStart
     * @return CourseStart
     */
    public function removeCourseStartedNote(CourseStart $courseStart): CourseStart
    {
        return $this->courseStartRepo->updateCourseStartNote([CourseStart::courseStartNote() => null], $courseStart);
    }
}
