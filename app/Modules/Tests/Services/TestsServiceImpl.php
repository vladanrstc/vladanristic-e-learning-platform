<?php

namespace App\Modules\Tests\Services;

use App\Models\Test;
use App\Modules\Lessons\Services\ILessonsService;
use App\Repositories\ILessonsRepo;
use App\Repositories\IQuestionsRepo;
use App\Repositories\ITestsRepo;
use Illuminate\Support\Facades\DB;

class TestsServiceImpl implements ITestsService
{

    /**
     * @var ITestsRepo
     */
    private ITestsRepo $testsRepo;

    /**
     * @var ILessonsRepo
     */
    private ILessonsRepo $lessonsRepo;

    /**
     * @var IQuestionsRepo
     */
    private IQuestionsRepo $questionsRepo;

    /**
     * @var ILessonsService
     */
    private ILessonsService $lessonsService;

    /**
     * @param  ITestsRepo  $testsRepo
     * @param  ILessonsRepo  $lessonsRepo
     * @param  IQuestionsRepo  $questionsRepo
     * @param  ILessonsService  $lessonsService
     */
    public function __construct(
        ITestsRepo $testsRepo,
        ILessonsRepo $lessonsRepo,
        IQuestionsRepo $questionsRepo,
        ILessonsService $lessonsService
    ) {
        $this->testsRepo      = $testsRepo;
        $this->lessonsRepo    = $lessonsRepo;
        $this->questionsRepo  = $questionsRepo;
        $this->lessonsService = $lessonsService;
    }

    /**
     * @param  string  $testName
     * @param  int  $lessonId
     * @param  string  $lang
     * @return Test
     */
    public function createTest(string $testName, int $lessonId, string $lang): Test
    {
        return DB::transaction(function () use ($testName, $lessonId, $lang) {
            $test = $this->testsRepo->createTest($testName, $lessonId, $lang);
            $this->lessonsService->updateLessonTest(
                $test->{Test::testId()},
                $this->lessonsService->getLessonByLessonId($lessonId));
            return $test;
        });
    }

    /**
     * @param  string  $testName
     * @param  string  $lang
     * @param  Test  $test
     * @return Test
     */
    public function updateTest(string $testName, string $lang, Test $test): Test
    {
        return $this->testsRepo->updateTest($testName, $lang, $test);
    }

    /**
     * @param  Test  $test
     * @return bool
     */
    public function deleteTest(Test $test): bool
    {
        return DB::transaction(function () use ($test) {
            // TODO: Simplify this with one query
            $this->lessonsRepo->updateLessonTest(null, $this->lessonsRepo->getLessonByTestId($test->test_id));

            $this->testsRepo->deleteTest($test);
        });
    }

    /**
     * @param $questionId
     * @param $answer
     * @return array
     */
    public function checkAnswer($questionId, $answer): array
    {
        $question               = $this->questionsRepo->getQuestionByIdWithCorrectAnswers($questionId);
        $questionWithAllAnswers = $this->questionsRepo->getQuestionById($questionId)->load("answers");

        if (is_array($answer)) {

            // the $answer variable actually contains multiple answers (array) - multiple choice question
            if (count($question->answers) == count($answer)) {

                $flag = true;
                foreach ($question->answers as $answer_db) {
                    if (!in_array($answer_db->answer_id, $answer)) {
                        $flag = false;
                        break;
                    }
                }
                return ["question" => $questionWithAllAnswers, "true" => $flag];

            } else {
                return ["question" => $questionWithAllAnswers, "true" => false];
            }

        } else {

            if ($question->answers[0]->answer_id == $answer) {
                return ["question" => $questionWithAllAnswers, "true" => true];
            } else {
                return ["question" => $questionWithAllAnswers, "true" => false];
            }
        }
    }
}
