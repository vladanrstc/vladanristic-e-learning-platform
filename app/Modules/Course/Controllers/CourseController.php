<?php

namespace App\Modules\Course\Controllers;

use App\Enums\Modules;
use App\Exceptions\MessageTranslationNotFoundException;
use App\Lang\LangHelper;
use App\Models\Course;
use App\Modules\Course\Exceptions\CourseNotFoundException;
use App\Modules\Course\Requests\CourseStoreRequest;
use App\Modules\Course\Services\CourseService;
use App\Modules\Course\Services\ICourseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class CourseController extends Controller
{

    /**
     * @var CourseService|ICourseService
     */
    private ICourseService|CourseService $courseService;

    public function __construct(CourseService $courseService) {
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
     * @param CourseStoreRequest $request
     * @return JsonResponse
     */
    public function store(CourseStoreRequest $request): JsonResponse
    {
        return response()->json([
            "data" => $this->courseService->createCourse(
                $request->get("course_name"),
                $request->get("course_description"),
                $request->get("course_image"),
                $request->get("lang")
            )]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Course $course
     * @return Response
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
     * @return JsonResponse
     * @throws MessageTranslationNotFoundException
     */
    public function destroy(Course $course): JsonResponse
    {
        if($this->courseService->deleteCourse($course)) {
            return response()->json(["message" => LangHelper::getMessage("course_deleted", Modules::COURSE)]);
        }
        return response()->json(["message" => LangHelper::getMessage("course_delete_error", Modules::COURSE)]);
    }

    /**
     * @param string $courseSlug
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
