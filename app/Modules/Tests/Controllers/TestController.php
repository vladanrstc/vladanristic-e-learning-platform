<?php

namespace App\Modules\Tests\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Test;
use App\Modules\Tests\Requests\TestStoreRequest;
use App\Modules\Tests\Requests\TestUpdateRequest;
use App\Modules\Tests\Services\ITestsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{

    /**
     * @var ITestsService
     */
    private ITestsService $testsService;

    /**
     * @param ITestsService $testsService
     */
    public function __construct(ITestsService $testsService) {
        $this->testsService = $testsService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TestStoreRequest $request
     * @return JsonResponse
     */
    public function store(TestStoreRequest $request): JsonResponse
    {
        return response()->json(["data" => $this->testsService->createTest(
            $request->input("test_name")[$request->input("lang")],
            $request->input("test_description")[$request->input("lang")],
            $request->input("lesson_id"),
            $request->input("lang")
        )]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TestUpdateRequest $request
     * @param Test $test
     * @return JsonResponse
     */
    public function update(TestUpdateRequest $request, Test $test): JsonResponse
    {
        return response()->json(["data" => $this->testsService->updateTest(
            $request->input("test_name")[$request->input("lang")],
            $request->input("test_description")[$request->input("lang")],
            $request->input("lang"),
            $test
        )]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Test  $test
     * @return JsonResponse
     */
    public function show(Test $test): JsonResponse
    {
        return response()->json(["data" => $test]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Test $test
     * @return JsonResponse
     */
    public function destroy(Test $test): JsonResponse
    {
        $deleteRes = $this->testsService->deleteTest($test);
        return response()->json(["data" => $deleteRes], $deleteRes ? 200 : 500);
    }

    /**
     * @param Test $test
     * @return JsonResponse
     */
    public function testRequirements(Test $test): JsonResponse
    {
        return response()->json(["data" => $test]);
    }

    /**
     * @param Lesson $lesson
     * @return JsonResponse
     */
    public function getTestData(Lesson $lesson): JsonResponse
    {
        return response()->json(["data" => Test::where("test_id", $lesson->lesson_test_id)
            ->with(["questions", "questions.answers"])
            ->get()]);
    }

    public function submit_test(Test $test, Request $request) {

        $return_results = [];
        $results = $request->answers;
        foreach ($results as $key => $value) {
            array_push($return_results, $this->check_answer($key, $value));
        }

        return $return_results;
    }

    public function check_answer($question_id, $answer) {

        $question = Question::where("question_id", $question_id)
            ->with(["answers" => function ($query) {
                $query->where("answer_true", 1);
            }])
            ->first();

        $question_with_all_answers = Question::where("question_id", $question_id)->with("answers")->first();

        if(is_array($answer)) {

            // the $answer variable actually contains multiple answers (array) - multiple choice question
            if(count($question->answers) == count($answer)) {

                $flag = true;
                foreach ($question->answers as $answer_db) {
                    if(!in_array($answer_db->answer_id, $answer)) {
                        $flag = false;
                        break;
                    }
                }
                return ["question" => $question_with_all_answers, "true" => $flag];

            } else {
                return ["question" => $question_with_all_answers, "true" => false];
            }

        } else {

            if($question->answers[0]->answer_id == $answer) {
                return ["question" => $question_with_all_answers, "true" => true];
            } else {
                return ["question" => $question_with_all_answers, "true" => false];
            }
        }

    }

}
