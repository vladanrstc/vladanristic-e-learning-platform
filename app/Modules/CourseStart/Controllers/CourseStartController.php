<?php

namespace App\Modules\CourseStart\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CourseStart\Requests\CourseEnrollRequest;
use App\Modules\CourseStart\Services\ICourseStartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CourseStartController extends Controller
{

    /**
     * @var ICourseStartService
     */
    private ICourseStartService $courseStartService;

    public function __construct(ICourseStartService $courseStartService) {
        $this->courseStartService = $courseStartService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseEnrollRequest $request
     * @return JsonResponse
     */
    public function enrollInCourse(CourseEnrollRequest $request): JsonResponse
    {
        return response()->json(["data" => $this->courseStartService->enrollUserToCourse($request->input("course_id"), Auth::id())]);
    }

    /**
     * @return JsonResponse
     */
    public function coursesNotStarted(): JsonResponse
    {
        return response()->json(["data" => $this->courseStartService->getCoursesUserHasntEnrolledIn(Auth::id())]);
    }

    /**
     * @return JsonResponse
     */
    public function coursesStarted(): JsonResponse
    {
        return response()->json(["data" => $this->courseStartService->getCoursesUserEnrolledIn(Auth::id())]);
    }

}
