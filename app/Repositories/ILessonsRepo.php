<?php

namespace App\Repositories;

use App\DTOs\FileDTO;
use App\Models\Lesson;

interface ILessonsRepo {
    public function createLesson(string $lessonTitle, string $lessonDescription, string $lessonCode, int $lessonSectionId, FileDTO $lessonPractice = null, string $lang): Lesson;
    public function updateLesson(string $lessonTitle, string $lessonDescription, string $lessonCode, FileDTO $lessonPractice = null, string $lang, Lesson $lesson): Lesson;
    public function updateLessonVideo(string $lessonVideoLink, Lesson $lesson, string $lang);
    public function updateLessonOrder(int $lessonOrder, Lesson $lesson);
    public function toggleLessonPublishedStatus(string $isLessonPublished, Lesson $lesson);
    public function updateLessonTest(int $lessonTestId, Lesson $lesson): Lesson;
    public function getLessonByLessonId(int $lessonId): Lesson|null;
    public function getLessonByTestId(int $testId): Lesson|null;
    public function deleteLesson(Lesson $lesson): bool;
}
