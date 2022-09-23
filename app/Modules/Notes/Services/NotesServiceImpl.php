<?php

namespace App\Modules\Notes\Services;

use App\Models\CourseStart;
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
     * @return CourseStart
     */
    public function getUserNotesForCourse(string $courseSlug, int $userId): CourseStart
    {
        return $this->courseStartRepo->getCourseStartForCourseAndUser($courseSlug, $userId);
    }

    /**
     * @param string $courseSlug
     * @param string $notes
     * @param int $userId
     * @return CourseStart
     */
    public function updateUserCourseStartedNotes(string $courseSlug, string $notes, int $userId): CourseStart
    {
        return $this->courseStartRepo->updateCourseStartNote(
            [CourseStart::courseStartNote() => $courseSlug],
            $this->courseStartRepo->getCourseStartForCourseAndUser($courseSlug, $userId)
        );
    }

    /**
     * @param CourseStart $courseStart
     * @return CourseStart
     */
    public function removeCourseStartedNote(CourseStart $courseStart): CourseStart
    {
        return $this->courseStartRepo->updateCourseStartNote([CourseStart::courseStartNote() => null], $courseStart);
    }

    /**
     * @param string $courseId
     * @return mixed
     */
    public function getNotesForCourse(string $courseId): mixed
    {
        return $this->courseStartRepo->getCourseNotes($courseId);
    }
}
