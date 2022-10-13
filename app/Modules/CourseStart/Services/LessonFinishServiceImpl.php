<?php

namespace App\Modules\CourseStart\Services;

use App\Models\CourseStart;
use App\Models\LessonCompleted;
use App\Repositories\ICourseStartRepo;
use App\Repositories\ILessonCompletedRepo;

class LessonFinishServiceImpl implements ILessonFinishService
{

    /**
     * @var ILessonCompletedRepo
     */
    private ILessonCompletedRepo $lessonCompletedRepo;

    /**
     * @var ICourseStartRepo
     */
    private ICourseStartRepo $courseStartRepo;

    public function __construct(ILessonCompletedRepo $lessonCompletedRepo, ICourseStartRepo $courseStartRepo)
    {
        $this->lessonCompletedRepo = $lessonCompletedRepo;
        $this->courseStartRepo     = $courseStartRepo;
    }

    /**
     * @param  int  $lessonId
     * @param  int  $userId
     * @return LessonCompleted
     */
    public function completeLesson(int $lessonId, int $userId): LessonCompleted
    {
        $courseStarted = $this->courseStartRepo->getCourseStartedForUserAndLessonId($lessonId, $userId);
        return $this->lessonCompletedRepo->addCompletedLesson($lessonId,
            $courseStarted->{CourseStart::courseStartedId()});
    }
}
