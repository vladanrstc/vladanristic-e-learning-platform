<?php

namespace App\Modules\Lessons\Controllers;

use App\DTOs\FileDTO;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Section;
use App\Modules\Lessons\Requests\ChangeLessonsOrderRequest;
use App\Modules\Lessons\Requests\LessonAttachVideoRequest;
use App\Modules\Lessons\Requests\LessonStoreRequest;
use App\Modules\Lessons\Requests\LessonUpdateRequest;
use App\Modules\Lessons\Requests\ToggleLessonPublishedRequest;
use App\Modules\Lessons\Services\ILessonsService;
use Illuminate\Http\JsonResponse;

class LessonsController extends Controller
{

    /**
     * @var ILessonsService
     */
    private ILessonsService $lessonsService;

    /**
     * @param  ILessonsService  $lessonsService
     */
    public function __construct(ILessonsService $lessonsService)
    {
        $this->lessonsService = $lessonsService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LessonStoreRequest  $request
     * @return JsonResponse
     */
    public function store(LessonStoreRequest $request): JsonResponse
    {
        return response()->json([
            "data" => $this->lessonsService->createLesson(
                $request->input("lesson_title"),
                $request->input("lesson_description"),
                $request->input("lesson_code"),
                $request->input("lesson_section_id"),
                !is_null($request->file("lesson_practice")) && $request->file("lesson_practice") !== "null" ? new FileDTO(
                    $request->file("lesson_practice")->getClientOriginalName(),
                    $request->file("lesson_practice")->getContent()) : null,
                $request->input("lang")
            )
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LessonUpdateRequest  $request
     * @param  Lesson  $lesson
     * @return JsonResponse
     */
    public function update(LessonUpdateRequest $request, Lesson $lesson)//: JsonResponse
    {
        return response()->json([
            "data" => $this->lessonsService->updateLesson(
                $request->input("lesson_title"),
                $request->input("lesson_description"),
                $request->input("lesson_code"),
                !is_null($request->file("lesson_practice")) && $request->file("lesson_practice") != "null" ? new FileDTO(
                    $request->file("lesson_practice")->getClientOriginalName(),
                    $request->file("lesson_practice")->getContent()) : null,
                $request->input("lang"),
                $lesson
            )
        ]);
    }

    /**public function loadSectionLessons(Section $section) {
     * $section->load(["lessons" => function ($query) {
     * $query->orderBy('lesson_order', 'asc');
     * }]);
     * return response()->json($section->lessons, 200);
     * }*/

    /**
     * @param  ChangeLessonsOrderRequest  $request
     * @return JsonResponse
     */
    public function changeLessonsOrder(ChangeLessonsOrderRequest $request): JsonResponse
    {
        return response()->json(["data" => $this->lessonsService->reorderLessons($request->input("lessons"))]);
    }

    /**
     * @param  ToggleLessonPublishedRequest  $request
     * @return JsonResponse
     */
    public function toggleLessonPublished(ToggleLessonPublishedRequest $request): JsonResponse
    {
        return response()->json([
            "data" => $this->lessonsService->toggleLessonPublishedStatus(
                $request->input('lesson_published'),
                $request->input('lesson_id')
            )
        ]);
    }

    /**
     * @param  LessonAttachVideoRequest  $request
     * @return JsonResponse
     */
    public function attachLessonVideo(LessonAttachVideoRequest $request): JsonResponse
    {
        return response()->json([
            "data" => $this->lessonsService->updateLessonVideoLink(
                $request->input("lesson_video_link"),
                $request->input("lesson_id"),
                $request->input("lang")
            )
        ]);
    }

    /**
     * @param  Section  $section
     * @return JsonResponse
     */
    public function sectionLessons(Section $section)//: JsonResponse
    {
        return response()->json([
            "data" => $section->lessons()->get()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Lesson  $lesson
     * @return JsonResponse
     */
    public function destroy(Lesson $lesson): JsonResponse
    {
        $deleteResult = $this->lessonsService->deleteLesson($lesson);
        return response()->json(["data" => $deleteResult], $deleteResult ? 200 : 500);
    }

}
