<?php

namespace App\Modules\Notes\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CourseStart;
use App\Models\Note;
use App\Modules\Notes\Services\INotesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{

    /**
     * @var INotesService
     */
    private INotesService $notesService;

    public function __construct(INotesService $notesService) {
        $this->notesService = $notesService;
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

    /**
     * @param $course
     * @return JsonResponse
     */
    public function getCourseNotes($course): JsonResponse
    {
        return response()->json(["data" => $this->notesService->getUserNotesForCourse($course,/* Auth::id()*/12)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CourseStart $courseStart
     * @return JsonResponse
     */
    public function destroy(CourseStart $courseStart): JsonResponse
    {
        return response()->json(["data" => $this->notesService->removeCourseStartedNote($courseStart)]);
    }

}
