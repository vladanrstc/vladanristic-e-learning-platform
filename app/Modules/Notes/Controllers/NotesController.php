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

    public function __construct(INotesService $notesService, ICourseStartService $courseStartService)
    {
        $this->notesService       = $notesService;
        $this->courseStartService = $courseStartService;
    }

    /**
     * @param  UpdateCourseNoteRequest  $request
     * @return JsonResponse
     */
    public function updateCourseNote(UpdateCourseNoteRequest $request): JsonResponse
    {
        return response()->json([
                "data" => $this->notesService->updateUserCourseStartedNotes(
                    $request->input("course"),
                    $request->input("notes"),
                    Auth::id())
            ]
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

    /**
     * @param $course
     * @return JsonResponse
     */
    public function courseNotes($course): JsonResponse
    {
        return response()->json(["data" => $this->notesService->getNotesForCourse($course)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CourseStart  $courseStart
     * @return JsonResponse
     */
    public function destroy(CourseStart $courseStart): JsonResponse
    {
        return response()->json(["data" => $this->notesService->removeCourseStartedNote($courseStart)]);
    }

}
