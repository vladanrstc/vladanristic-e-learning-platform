<?php

namespace App\Modules\Lessons\Services;

use App\DTOs\FileDTO;
use App\Models\Lesson;
use Illuminate\Support\Collection;

interface ILessonsService
{
    public function createLesson(
        string $lessonTitle,
        string $lessonDescription,
        string $lessonCode = null,
        int $lessonSectionId,
        FileDTO $lessonPractice = null,
        string $lang
    ): Lesson;

    public function updateLesson(
        string $lessonTitle,
        string $lessonDescription,
        string $lessonCode = null,
        FileDTO $lessonPractice = null,
        string $lang,
        Lesson $lesson
    ): Lesson;

    public function getLessonByLessonId(int $lessonId): ?Lesson;

    public function updateLessonVideoLink(string $lessonVideoLink, int $lessonId, string $lang): Lesson;

    public function toggleLessonPublishedStatus(bool $isLessonPublished, int $lessonId): Lesson;

    public function reorderLessons(array $lessons): Collection;

    public function updateLessonTest(int $lessonTestId, Lesson $lesson): Lesson;

    public function deleteLesson(Lesson $lesson): bool;
}
