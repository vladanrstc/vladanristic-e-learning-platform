<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
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

        $test = Test::create(request()->validate([
            'test_name.'.$lang => 'required|max:255|min:3',
            'test_description' => '',
        ]));

        $test->save();

        $lesson = Lesson::where("lesson_id", $request->lesson_id)->first();
        $lesson->lesson_test_id = $test->test_id;
        $lesson->save();

        return response()->json($test, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        return $test;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        $lang = $request->lang;
        request()->validate([
            'test_name.'.$lang => 'required|max:255|min:3',
            'test_description' => ''
        ]);

        $test->setTranslation('test_name', $lang, $request->test_name[$lang]);
        $test->save();

        return response()->json($test, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Test $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        $lesson = Lesson::where("lesson_test_id", $test->test_id)->first();
        $lesson->lesson_test_id = null;
        $lesson->save();

        $test->delete();
        return response()->json("success", 200);
    }

    public function test_requirements(Test $test) {
        return $test;
    }

    public function get_test_data(Lesson $lesson) {
        return Test::where("test_id", $lesson->lesson_test_id)
            ->with(["questions", "questions.answers"])
            ->get();
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
