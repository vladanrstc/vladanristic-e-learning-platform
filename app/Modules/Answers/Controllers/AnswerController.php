<?php

namespace App\Modules\Answers\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Modules\Answers\Requests\AnswerUpdateRequest;
use App\Modules\Answers\Services\IAnswersService;
use Illuminate\Http\JsonResponse;

class AnswerController extends Controller
{

    /**
     * @var IAnswersService
     */
    private IAnswersService $answersService;

    /**
     * @param  IAnswersService  $answersService
     */
    public function __construct(IAnswersService $answersService)
    {
        $this->answersService = $answersService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AnswerUpdateRequest  $request
     * @return JsonResponse
     */
    public function store(AnswerUpdateRequest $request): JsonResponse
    {
        return response()->json([
            "data" => $this->answersService->createAnswer(
                $request->input("answer_text")[$request->input("lang")],
                $request->input("question"),
                $request->input("answer_true"),
                $request->input("lang")
            )
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AnswerUpdateRequest  $request
     * @param  Answer  $answer
     * @return JsonResponse
     */
    public function update(AnswerUpdateRequest $request, Answer $answer)
    {
        return response()->json([
            "data" => $this->answersService->updateAnswer(
                $request->input("answer_text")[$request->input("lang")],
                $request->input("answer_true"),
                $request->input("lang"),
                $answer
            )
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Answer  $answer
     * @return JsonResponse
     */
    public function destroy(Answer $answer)
    {
        $deleteRes = $this->answersService->deleteAnswer($answer);
        return response()->json(["data" => $deleteRes], $deleteRes ? 200 : 500);
    }
}
