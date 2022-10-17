<?php

namespace App\Modules\Questions\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Modules\Questions\Requests\QuestionStoreRequest;
use App\Modules\Questions\Requests\QuestionUpdateRequest;
use App\Modules\Questions\Services\IQuestionsService;
use Illuminate\Http\JsonResponse;

class QuestionController extends Controller
{

    /**
     * @var IQuestionsService
     */
    private IQuestionsService $questionsService;

    /**
     * @param  IQuestionsService  $questionsService
     */
    public function __construct(IQuestionsService $questionsService)
    {
        $this->questionsService = $questionsService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  QuestionStoreRequest  $request
     * @return JsonResponse
     */
    public function store(QuestionStoreRequest $request): JsonResponse
    {
        return response()->json([
            "data" => $this->questionsService->createQuestion(
                $request->input("question_text")[$request->input("lang")],
                $request->input("test"),
                $request->input("lang"))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  QuestionUpdateRequest  $request
     * @param  Question  $question
     * @return JsonResponse
     */
    public function update(QuestionUpdateRequest $request, Question $question): JsonResponse
    {
        return response()->json([
            "data" => $this->questionsService->updateQuestion(
                $request->input("question_text")[$request->input("lang")],
                $request->input("lang"),
                $question
            )
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Question  $question
     * @return JsonResponse
     */
    public function destroy(Question $question): JsonResponse
    {
        $deleteResult = $this->questionsService->deleteQuestion($question);
        return response()->json(["data" => $deleteResult], $deleteResult ? 200 : 500);
    }

    /**
     * @param $test
     * @return mixed
     */
    public function testQuestions($test): mixed
    {
        return response()->json(["data" => $this->questionsService->getTestQuestions($test)]);
    }

}
