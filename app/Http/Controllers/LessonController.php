<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LessonController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $lang = $request->lang;
            request()->validate([
                'lesson_title' => 'required|max:255|min:3',
                'lesson_description' => 'required|max:255|min:3',
                'lesson_code' => 'max:255',
                'lesson_section_id' => 'required'
            ]);

            $lesson = new Lesson();

            $lesson->setTranslation('lesson_title', $lang, $request->lesson_title);
            $lesson->setTranslation('lesson_description', $lang, $request->lesson_description);
            $lesson->lesson_code = $request->lesson_code;
            $lesson->lesson_section_id = $request->lesson_section_id;

            if($request->lesson_practice != 'null') {
                $lesson->setTranslation('lesson_practice', $lang, $request->lesson_practice->store('lessons_documents', 'public'));
            }

            $lesson->lesson_slug = rand(100, 100000) . "-" . Str::slug($request->lesson_title, "-");

            $last_lesson = Lesson::where("lesson_section_id", $request->lesson_section_id)
                ->orderBy("lesson_order", "desc")
                ->first();
            if($last_lesson != null) {
                $lesson->lesson_order = $last_lesson->lesson_order + 1;
            } else {
                $lesson->lesson_order = 1;
            }

            $lesson->save();

            return response()->json(["lesson_name" => $request->lesson_title, "lesson_description" => $request->lesson_description], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json($e->getMessage(), 422);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {

        $lang = $request->lang;
        request()->validate([
            'lesson_title' => 'required|max:255|min:3',
            'lesson_description' => 'required|max:255|min:3',
            'lesson_code' => 'max:255',
        ]);

        $lesson->setTranslation('lesson_title', $lang, $request->lesson_title);
        $lesson->setTranslation('lesson_description', $lang, $request->lesson_description);

        if($request->lesson_code != 'null') {
            $lesson->lesson_code = $request->lesson_code;
        }

        if($request->lesson_practice != 'null') {
            $lesson->setTranslation('lesson_practice', $lang, $request->lesson_practice->store('lessons_documents', 'public'));
        }

        $lesson->save();

        return response()->json("success", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return response()->json("success", 200);
    }

    public function section_lessons(Section $section) {
        $section->load(["lessons" => function ($query) {
            $query->orderBy('lesson_order', 'asc');
        }]);
        return response()->json($section->lessons, 200);
    }

    public function lessons_order(Request $request) {

        $count = 1;
        $lessons = Lesson::hydrate($request->lessons);
        foreach ($lessons as $lesson) {
            $lesson->lesson_order = $count;
            $lesson->save();
            $count++;
        }

        return response()->json("success", 200);
    }

    public function lessons_switch(Request $request) {
        $lesson = Lesson::findOrFail($request->lesson_id);
        $lesson->lesson_published = $request->lesson_published;
        $lesson->save();
        return response()->json("success", 200);
    }

    public function lessons_video(Request $request) {

        $lang = $request->lang;
        $lesson = Lesson::where("lesson_id", $request->lesson_id)->first();
        $lesson->setTranslation('lesson_video_link', $lang, $request->lesson_video_link);
        $lesson->save();
        return response()->json("success", 200);

    }

}
