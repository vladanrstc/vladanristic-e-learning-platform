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
     * @param  ITestsService  $testsService
     */
    public function __construct(ITestsService $testsService)
    {
        $this->testsService = $testsService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TestStoreRequest  $request
     * @return JsonResponse
     */
    public function store(TestStoreRequest $request): JsonResponse
    {
        return response()->json([
            "data" => $this->testsService->createTest(
                $request->input("test_name")[$request->input("lang")],
                $request->input("test_description")[$request->input("lang")],
                $request->input("lesson_id"),
                $request->input("lang")
            )
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TestUpdateRequest  $request
     * @param  Test  $test
     * @return JsonResponse
     */
    public function update(TestUpdateRequest $request, Test $test): JsonResponse
    {
        return response()->json([
            "data" => $this->testsService->updateTest(
                $request->input("test_name")[$request->input("lang")],
                $request->input("test_description")[$request->input("lang")],
                $request->input("lang"),
                $test
            )
        ]);
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
     * @param  Test  $test
     * @return JsonResponse
     */
    public function destroy(Test $test): JsonResponse
    {
        $deleteRes = $this->testsService->deleteTest($test);
        return response()->json(["data" => $deleteRes], $deleteRes ? 200 : 500);
    }

    /**
     * @param  Test  $test
     * @return JsonResponse
     */
    public function testRequirements(Test $test): JsonResponse
    {
        return response()->json(["data" => $test]);
    }

    /**
     * @param  Lesson  $lesson
     * @return JsonResponse
     */
    public function getTestData(Lesson $lesson): JsonResponse
    {
        return response()->json(["data" => $lesson->test()->with(["questions", "questions.answers"])->get()]);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function submitTest(Request $request): JsonResponse
    {

        $return_results = [];
        $results        = $request->answers;
        foreach ($results as $key => $value) {
            array_push($return_results, $this->testsService->checkAnswer($key, $value));
        }

        return response()->json(["data" => $return_results]);
    }

}
