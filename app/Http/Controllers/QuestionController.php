<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lang = $request->lang;
        request()->validate([
            'question_text.'.$lang => 'required|max:255|min:3'
        ]);

        $question = new Question();
        $question->setTranslation('question_text', $lang, $request->question_text[$lang]);
        $question->test_id = $request->test;
        $question->save();

        return response()->json("success", 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $lang = $request->lang;
        request()->validate([
            'question_text.'.$lang => 'required|max:255|min:3'
        ]);

        $question->setTranslation('question_text', $lang, $request->question_text[$lang]);
        $question->save();

        return response()->json("success", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json("success", 200);
    }

    public function test_questions($test) {
        return Question::where("test_id", $test)->with('answers')->get();
    }

    public function aaa() {
        return Question::where("question_id", "2")->with('answers')->get();
    }

}
