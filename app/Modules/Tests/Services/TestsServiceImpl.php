<?php

namespace App\Modules\Tests\Services;

use App\Models\Lesson;
use App\Models\Test;
use App\Repositories\ILessonsRepo;
use App\Repositories\ITestsRepo;
use Illuminate\Support\Facades\DB;

class TestsServiceImpl implements ITestsService {

    /**
     * @var ITestsRepo
     */
    private ITestsRepo $testsRepo;

    /**
     * @var ILessonsRepo
     */
    private ILessonsRepo $lessonsRepo;

    /**
     * @param ITestsRepo $testsRepo
     * @param ILessonsRepo $lessonsRepo
     */
    public function __construct(ITestsRepo $testsRepo, ILessonsRepo $lessonsRepo) {
        $this->testsRepo   = $testsRepo;
        $this->lessonsRepo = $lessonsRepo;
    }

    /**
     * @param string $testName
     * @param string $testDescription
     * @param int $lessonId
     * @param string $lang
     * @return Test
     */
    public function createTest(string $testName, string $testDescription, int $lessonId, string $lang): Test
    {
        return $this->testsRepo->createTest($testName, $testDescription, $lessonId, $lang);
    }

    /**
     * @param string $testName
     * @param string $testDescription
     * @param string $lang
     * @param Test $test
     * @return Test
     */
    public function updateTest(string $testName, string $testDescription, string $lang, Test $test): Test
    {
        return $this->testsRepo->updateTest($testName, $testDescription, $lang, $test);
    }

    /**
     * @param Test $test
     * @return bool
     */
    public function deleteTest(Test $test): bool
    {
        return DB::transaction(function() use($test) {
            // TODO: Simplify this with one query
            $this->lessonsRepo->updateLessonTest(null, $this->lessonsRepo->getLessonByTestId($test->test_id));

            $this->testsRepo->deleteTest($test);
        });
    }
}
