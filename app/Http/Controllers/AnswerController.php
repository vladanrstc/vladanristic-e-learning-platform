<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnswerController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $lang = $request->lang;
        request()->validate([
            'answer_text.'.$lang => 'required|max:255|min:3',
            'answer_true' => 'required',
        ]);

        $answer = new Answer();
        $answer->setTranslation('answer_text', $lang, $request->answer_text[$lang]);
        $answer->question_id = $request->question;
        $answer->answer_true = $request->answer_true;
        $answer->save();

        return response()->json("success");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  Answer $answer
     * @return JsonResponse
     */
    public function update(Request $request, Answer $answer)
    {
        $lang = $request->lang;
        request()->validate([
            'answer_text.'.$lang => 'required|max:255|min:3',
            'answer_true' => 'required',
        ]);

        $answer->setTranslation('answer_text', $lang, $request->answer_text[$lang]);
        $answer->answer_true = $request->answer_true;
        $answer->save();

        return response()->json("success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Answer  $answer
     * @return JsonResponse
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();
        return response()->json("success");
    }
}
