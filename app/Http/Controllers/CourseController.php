<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Course::orderBy('created_at', 'desc')->paginate(8);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            $lang = $request->lang;

            request()->validate([
                'course_name' => 'required|max:255|min:3',
                'course_description' => 'required|max:1024|min:3',
                'course_image' => 'image'
            ]);

            $course = new Course();
            $course->setTranslation('course_name', $lang, $request->course_name);
            $course->setTranslation('course_description', $lang, $request->course_description);
            $course->course_slug = rand(100, 100000) . "-" . Str::slug($request->course_name, "-");

            $course->course_image = $request->course_image->store('course_photos', 'public');

            $course->save();

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json("error", 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {

        try {

            $lang = $request->lang;

            request()->validate([
                'course_name' => 'required|max:255|min:3',
                'course_description' => 'required|max:1024|min:3',
            ]);

            $course->setTranslation('course_name', $lang, $request->course_name);
            $course->setTranslation('course_description', $lang, $request->course_description);

            if ($request->course_image != "null") {
                $course->course_image = $request->course_image->store('course_photos', 'public');
            }

            $course->save();

            return response()->json("success", 200);
        } catch (\Exception $e) {
            return response()->json($e, 422);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json("success", 200);
    }

    public function course_details($course)
    {

        return Course::where("course_slug", $course)
            ->with(["sections" => function ($query) {
                $query->orderBy("section_order", "ASC");
            },
                "sections.lessons" => function ($query) {
                    $query->where("lesson_published", "1")
                        ->orderBy("lesson_order", "ASC");
                },
                "sections.lessons.test"
            ])
            ->first();
    }

    public function all_courses() {
        return Course::all();
    }

}
