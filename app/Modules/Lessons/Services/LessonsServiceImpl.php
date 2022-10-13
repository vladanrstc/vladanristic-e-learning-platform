<?php

namespace App\Modules\Lessons\Services;

use App\DTOs\FileDTO;
use App\Models\Lesson;
use App\Repositories\ILessonsRepo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LessonsServiceImpl implements ILessonsService
{

    /**
     * @var ILessonsRepo
     */
    private ILessonsRepo $lessonsRepo;

    /**
     * @param  ILessonsRepo  $lessonsRepo
     */
    public function __construct(ILessonsRepo $lessonsRepo)
    {
        $this->lessonsRepo = $lessonsRepo;
    }

    /**
     * @param  string  $lessonTitle
     * @param  string  $lessonDescription
     * @param  string|null  $lessonCode
     * @param  int  $lessonSectionId
     * @param  FileDTO|null  $lessonPractice
     * @param  string  $lang
     * @return Lesson
     */
    public function createLesson(
        string $lessonTitle,
        string $lessonDescription,
        string $lessonCode = null,
        int $lessonSectionId,
        FileDTO $lessonPractice = null,
        string $lang
    ): Lesson {
        return $this->lessonsRepo->createLesson($lessonTitle, $lessonDescription, $lessonCode, $lessonSectionId,
            $lessonPractice, $lang);
    }

    /**
     * @param  string  $lessonTitle
     * @param  string  $lessonDescription
     * @param  string|null  $lessonCode
     * @param  FileDTO|null  $lessonPractice
     * @param  string  $lang
     * @param  Lesson  $lesson
     * @return Lesson
     */
    public function updateLesson(
        string $lessonTitle,
        string $lessonDescription,
        string $lessonCode = null,
        FileDTO $lessonPractice = null,
        string $lang,
        Lesson $lesson
    ): Lesson {
        return $this->lessonsRepo->updateLesson($lessonTitle, $lessonDescription, $lessonCode, $lessonPractice, $lang,
            $lesson);
    }

    /**
     * @param  string  $lessonVideoLink
     * @param  int  $lessonId
     * @param  string  $lang
     * @return Lesson
     */
    public function updateLessonVideoLink(string $lessonVideoLink, int $lessonId, string $lang): Lesson
    {
        return $this->lessonsRepo->updateLessonVideo(
            $lessonVideoLink,
            $this->lessonsRepo->getLessonByLessonId($lessonId), $lang
        );
    }

    /**
     * @param  bool  $isLessonPublished
     * @param  int  $lessonId
     * @return Lesson
     */
    public function toggleLessonPublishedStatus(bool $isLessonPublished, int $lessonId): Lesson
    {
        return $this->lessonsRepo->toggleLessonPublishedStatus(
            $isLessonPublished,
            $this->lessonsRepo->getLessonByLessonId($lessonId)
        );
    }

    /**
     * @param  array  $lessons
     * @return Collection
     */
    public function reorderLessons(array $lessons): Collection
    {
        return DB::transaction(function () use ($lessons) {
            $count   = 1;
            $lessons = Lesson::hydrate($lessons);
            foreach ($lessons as $lesson) {
                $this->lessonsRepo->updateLessonOrder($count, $lesson);
                $count++;
            }
            return $lessons;
        });
    }

    /**
     * @param  Lesson  $lesson
     * @return bool
     */
    public function deleteLesson(Lesson $lesson): bool
    {
        return $this->lessonsRepo->deleteLesson($lesson);
    }
}
