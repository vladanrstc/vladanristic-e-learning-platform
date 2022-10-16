<?php

namespace App\Repositories;

use App\Models\Test;

class TestsRepo implements ITestsRepo
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
     * @param  string  $testName
     * @param  int  $lessonId
     * @param  string  $lang
     * @return Test
     */
    public function createTest(string $testName, int $lessonId, string $lang): Test
    {
        $test = new Test();
        $test->setTranslation(Test::testName(), $lang, $testName);
        $test->save();

        $this->lessonsRepo->updateLessonTest(
            $test->{Test::testId()},
            $this->lessonsRepo->getLessonByLessonId($lessonId));

        return $test;
    }

    /**
     * @param  string  $testName
     * @param  string  $lang
     * @param  Test  $test
     * @return Test
     */
    public function updateTest(string $testName, string $lang, Test $test): Test
    {
        $test->setTranslation(Test::testName(), $lang, $testName);
        $test->save();
        return $test;
    }

    /**
     * @param  Test  $test
     * @return bool
     */
    public function deleteTest(Test $test): bool
    {
        if ($test->delete()) {
            return true;
        }
        return false;
    }

}
