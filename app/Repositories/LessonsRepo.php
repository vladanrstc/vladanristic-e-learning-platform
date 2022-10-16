<?php

namespace App\Repositories;

use App\DTOs\FileDTO;
use App\Enums\Modules;
use App\Models\Lesson;
use App\StorageManagement\StorageHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LessonsRepo implements ILessonsRepo
{

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

        return DB::transaction(function () use (
            $lessonTitle,
            $lessonDescription,
            $lessonCode,
            $lessonSectionId,
            $lessonPractice,
            $lang
        ) {

            $lesson = new Lesson();

            $lesson->setTranslation(Lesson::lessonTitle(), $lang, $lessonTitle);
            $lesson->setTranslation(Lesson::lessonDescription(), $lang, $lessonDescription);

            !is_null($lessonCode) ? $lesson->{Lesson::lessonCode()} = $lessonCode : false;
            $lesson->{Lesson::lessonSectionId()} = $lessonSectionId;
            $lesson->{Lesson::lessonSlug()}      = rand(100, 100000)."-".Str::slug($lessonTitle, "-");

            if (!is_null($lessonPractice)) {
                $lesson->setTranslation(
                    Lesson::lessonPractice(), $lang,
                    StorageHelper::storeFile("public", $lessonPractice, Modules::LESSONS->value, "lesson_practices"));
            }

            $last_lesson = Lesson::where(Lesson::lessonSectionId(), $lessonSectionId)
                ->orderBy(Lesson::lessonOrder(), "desc")
                ->first();

            if (!is_null($last_lesson)) {
                $lesson->{Lesson::lessonOrder()} = $last_lesson->{Lesson::lessonOrder()} + 1;
            } else {
                $lesson->{Lesson::lessonOrder()} = 1;
            }

            $lesson->save();

            return $lesson;

        });

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
        return DB::transaction(function () use (
            $lessonTitle,
            $lessonDescription,
            $lessonCode,
            $lessonPractice,
            $lang,
            $lesson
        ) {

            $lesson->setTranslation(Lesson::lessonTitle(), $lang, $lessonTitle);
            $lesson->setTranslation(Lesson::lessonDescription(), $lang, $lessonDescription);

            if ($lessonCode != 'null') {
                $lesson->{Lesson::lessonCode()} = $lessonCode;
            }

            if (!is_null($lessonPractice)) {
                $lesson->setTranslation(
                    Lesson::lessonPractice(), $lang,
                    StorageHelper::storeFile("public", $lessonPractice, Modules::LESSONS->value, "lesson_practices"));
            }

            $lesson->save();

            return $lesson;
        });

    }

    /**
     * @param  int  $lessonId
     * @return Lesson|null
     */
    public function getLessonByLessonId(int $lessonId): Lesson|null
    {
        return Lesson::where(Lesson::lessonId(), $lessonId)->first();
    }

    /**
     * @param  string  $lessonVideoLink
     * @param  Lesson  $lesson
     * @param  string  $lang
     * @return Lesson
     */
    public function updateLessonVideo(string $lessonVideoLink, Lesson $lesson, string $lang): Lesson
    {
        $lesson->setTranslation(Lesson::lessonVideoLink(), $lang, $lessonVideoLink);
        $lesson->save();
        return $lesson;
    }

    /**
     * @param  bool  $isLessonPublished
     * @param  Lesson  $lesson
     * @return Lesson
     */
    public function toggleLessonPublishedStatus(bool $isLessonPublished, Lesson $lesson): Lesson
    {

        $lesson->{Lesson::lessonPublished()} = $isLessonPublished;
        $lesson->save();
        return $lesson;
    }

    /**
     * @param  int  $lessonOrder
     * @param  Lesson  $lesson
     * @return Lesson
     */
    public function updateLessonOrder(int $lessonOrder, Lesson $lesson)
    {
        $lesson->{Lesson::lessonOrder()} = $lessonOrder;
        $lesson->save();
        return $lesson;
    }

    /**
     * @param  Lesson  $lesson
     * @return bool
     */
    public function deleteLesson(Lesson $lesson): bool
    {
        if ($lesson->delete()) {
            return true;
        }
        return false;
    }

    /**
     * @param  int|null  $lessonTestId
     * @param  Lesson  $lesson
     * @return Lesson
     */
    public function updateLessonTest(int $lessonTestId = null, Lesson $lesson): Lesson
    {
        $lesson->{Lesson::lessonTestId()} = $lessonTestId;
        $lesson->save();
        return $lesson;
    }

    /**
     * @param  int  $testId
     * @return Lesson|null
     */
    public function getLessonByTestId(int $testId): Lesson|null
    {
        return Lesson::where(Lesson::lessonTestId(), $testId)->first();
    }
}
