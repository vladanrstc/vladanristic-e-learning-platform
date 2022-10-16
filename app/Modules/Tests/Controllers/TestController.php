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
    public function storeOrUpdate(TestStoreRequest $request): JsonResponse
    {
        return response()->json([
            "data" => $this->testsService->createOrUpdateTest(
                $request->input("test_name")[$request->input("lang")],
                $request->input("lesson_id"),
                $request->input("lang")
            )
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Lesson  $lesson
     * @return JsonResponse
     */
    public function show(Lesson $lesson): JsonResponse
    {
        return response()->json(["data" => $lesson->test()->first() ?? ""]);
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
