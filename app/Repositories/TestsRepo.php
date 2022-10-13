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
     * @param  string  $testDescription
     * @param  int  $lessonId
     * @param  string  $lang
     * @return Test
     */
    public function createTest(string $testName, string $testDescription, int $lessonId, string $lang): Test
    {
        $test = new Test();
        $test->setTranslation(Test::testName(), $lang, $testName);
        $test->setTranslation(Test::testDescription(), $lang, $testDescription);
        $test->save();

        $this->lessonsRepo->updateLessonTest($test->{Test::testId()},
            $this->lessonsRepo->getLessonByLessonId($lessonId));

        return $test;
    }

    /**
     * @param  string  $testName
     * @param  string  $testDescription
     * @param  string  $lang
     * @param  Test  $test
     * @return Test
     */
    public function updateTest(string $testName, string $testDescription, string $lang, Test $test): Test
    {
        $test->setTranslation(Test::testName(), $lang, $testName);
        $test->setTranslation(Test::testDescription(), $lang, $testDescription);
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
