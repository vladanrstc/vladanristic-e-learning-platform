<?php

namespace App\Modules\Notes\Services;

use App\Models\CourseStart;
use App\Repositories\ICourseStartRepo;
use Illuminate\Support\Collection;

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
     * @return CourseStart|null
     */
    public function getUserNotesForCourse(string $courseSlug, int $userId): CourseStart|null
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
        return $this->courseStartRepo->updateCourseStart(
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
        return $this->courseStartRepo->updateCourseStart([CourseStart::courseStartNote() => null], $courseStart);
    }

    /**
     * @param string $courseId
     * @return Collection|null
     */
    public function getNotesForCourse(string $courseId): CourseStart|null
    {
        return $this->courseStartRepo->getCourseNotes($courseId);
    }
}
