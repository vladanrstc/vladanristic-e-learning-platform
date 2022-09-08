<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Section::paginate(8);
    }

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
            $section = Section::create(request()->validate([
                'section_name.'.$lang => 'required|max:255|min:3',
                'section_course_id' => 'required'
            ]));

            $last_section = Section::where("section_course_id", $request->section_course_id)
                ->orderBy("section_order", "desc")
                ->first();
            if($last_section != null) {
                $section->section_order = $last_section->section_order + 1;
            } else {
                $section->section_order = 1;
            }

            $section->save();

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json("error", 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        try {

            $lang = $request->lang;
            request()->validate([
                'section_name.'.$lang => 'required|max:255|min:3'
            ]);

            $section->setTranslation('section_name', $lang, $request->section_name[$lang]);
            $section->save();

            return response()->json("success", 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json("error2", 422);
        } catch (\Throwable $e) {
            return response()->json("error1", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return response()->json("success", 200);
    }

    public function course_sections(Course $course) {
        $course->load(["sections" => function ($query) {
            $query->orderBy('section_order', 'asc');
        }]);
        return response()->json($course->sections, 200);
    }

    public function sections_order(Request $request) {
        $count = 1;
        $sections = Section::hydrate($request->sections);
        foreach ($sections as $section) {
            $section->section_order = $count;
            $section->save();
            $count++;
        }

        return response()->json("success", 200);
    }

}
