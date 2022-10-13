<?php

namespace App\Modules\Course\Controllers;

use App\DTOs\FileDTO;
use App\Enums\Modules;
use App\Exceptions\MessageTranslationNotFoundException;
use App\Lang\LangHelper;
use App\Models\Course;
use App\Modules\Course\Requests\CourseStoreRequest;
use App\Modules\Course\Requests\CourseUpdateRequest;
use App\Modules\Course\Services\CourseService;
use App\Modules\Course\Services\ICourseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CourseController extends Controller
{

    /**
     * @var CourseService|ICourseService
     */
    private ICourseService|CourseService $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(["data" => Course::orderBy('created_at', 'desc')->paginate(8)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CourseStoreRequest  $request
     * @return JsonResponse
     */
    public function store(CourseStoreRequest $request): JsonResponse
    {
        return response()->json([
            "data" => $this->courseService->createCourse(
                $request->input("course_name"),
                $request->input("course_description"),
                new FileDTO($request->file("course_image")->getClientOriginalName(),
                    $request->file("course_image")->getContent()),
                $request->input("lang")
            )
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CourseUpdateRequest  $request
     * @param  Course  $course
     * @return JsonResponse
     */
    public function update(CourseUpdateRequest $request, Course $course)//: JsonResponse
    {

        $image = null;
        if ($request->input("course_image") != "null") {
            $image = $request->file("course_image");
        }

        return response()->json([
            "data" => $this->courseService->updateCourse(
                $course,
                $request->input("course_name"),
                $request->input("course_description"),
                !is_null($image) ? new FileDTO($request->file("course_image")->getClientOriginalName(),
                    $request->file("course_image")->getContent()) : null,
                $request->input("lang")
            )
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Course  $course
     * @return JsonResponse
     * @throws MessageTranslationNotFoundException
     */
    public function destroy(Course $course): JsonResponse
    {
        if ($this->courseService->deleteCourse($course)) {
            return response()->json(["message" => LangHelper::getMessage("course_deleted", Modules::COURSE)]);
        }
        return response()->json(["message" => LangHelper::getMessage("course_delete_error", Modules::COURSE)]);
    }

    /**
     * @param  string  $courseSlug
     * @return JsonResponse
     */
    public function courseDetails(string $courseSlug): JsonResponse
    {
        try {
            return response()->json(["data" => $this->courseService->getCourseDetailsByCourseSlug($courseSlug)]);
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage()]);
        }
    }

    /**
     * @return JsonResponse
     */
    public function allCourses(): JsonResponse
    {
        return response()->json(["data" => $this->courseService->getAllCourses()]);
    }

}
