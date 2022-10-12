<?php

namespace App\Modules\Notes\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CourseStart;
use App\Modules\CourseStart\Services\ICourseStartService;
use App\Modules\Notes\Requests\UpdateCourseNoteRequest;
use App\Modules\Notes\Services\INotesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{

    /**
     * @var INotesService
     */
    private INotesService $notesService;

    /**
     * @var ICourseStartService
     */
    private ICourseStartService $courseStartService;

    public function __construct(INotesService $notesService, ICourseStartService $courseStartService) {
        $this->notesService       = $notesService;
        $this->courseStartService = $courseStartService;
    }

    /**
     * @param UpdateCourseNoteRequest $request
     * @return JsonResponse
     */
    public function updateCourseNote(UpdateCourseNoteRequest $request): JsonResponse
    {
        return response()->json(["data" => $this->notesService->updateUserCourseStartedNotes(
            $request->input("course"),
            $request->input("notes"),
            Auth::id())]
        );
    }

    /**
     * @param $course
     * @return JsonResponse
     */
    public function getCourseNotes($course): JsonResponse
    {
        return response()->json(["data" => $this->notesService->getUserNotesForCourse($course, Auth::id())]);
    }

    public function courseNotes($course) {
        return CourseStart::where("course_id", $course)
            ->whereNotNull("user_course_started_note")
            ->with('user')
            ->paginate(10);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $courseStart
     * @return JsonResponse
     */
    public function destroy($courseStart): JsonResponse
    {
        return response()->json(["data" => $this->notesService->removeCourseStartedNote($this->courseStartService->getCourseStartById($courseStart))]);
    }

}
