<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseStart;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->user_course_started_note = null;
        $note->save();
        return response()->json("success", 200);
    }

    public function course_notes($course) {
        return CourseStart::where("course_id", $course)
            ->whereNotNull("user_course_started_note")
            ->with('user')->paginate(10);
    }

    public function update_course_note(Request $request) {
        $course = Course::where("course_slug", "like", $request->course)->first();
        $started_course = CourseStart::where("course_id", $course->course_id)->where("user_id", Auth::id())->first();
        $started_course->user_course_started_note = $request->notes;
        $started_course->save();
        return response()->json("success", 200);
    }

    public function get_course_note($course) {
        $course = Course::where("course_slug", "like", $course)->first();
        return CourseStart::where("course_id", $course->course_id)->where("user_id", Auth::id())->first();
    }

}
