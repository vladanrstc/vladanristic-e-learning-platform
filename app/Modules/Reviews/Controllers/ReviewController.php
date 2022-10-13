<?php

namespace App\Modules\Reviews\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CourseStart;
use App\Modules\CourseStart\Services\ICourseStartService;
use App\Modules\Reviews\Requests\UpdateCourseReviewRequest;
use App\Modules\Reviews\Services\IReviewsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{

    /**
     * @var IReviewsService
     */
    private IReviewsService $reviewsService;

    /**
     * @var ICourseStartService
     */
    private ICourseStartService $courseStartService;

    public function __construct(IReviewsService $reviewsService, ICourseStartService $courseStartService)
    {
        $this->reviewsService     = $reviewsService;
        $this->courseStartService = $courseStartService;
    }

    /**
     * @param  string  $courseSlug
     * @return JsonResponse
     */
    public function getCourseReviews(string $courseSlug): JsonResponse
    {
        return response()->json(["data" => $this->reviewsService->getCourseReviews($courseSlug)]);
    }

    /**
     * @param $course
     * @return JsonResponse
     */
    public function getAllCourseReviewMarks($course): JsonResponse
    {
        return response()->json(["data" => $this->reviewsService->getCourseReviewMarks($course)]);
    }

    /**
     * @param  UpdateCourseReviewRequest  $request
     * @return JsonResponse
     */
    public function updateCourseReview(UpdateCourseReviewRequest $request): JsonResponse
    {
        return response()->json([
            "data" => $this->reviewsService->updateCourseStartReview(
                $request->input("course"),
                $request->input("review"),
                $request->input("rating"),
                Auth::id()
            )
        ]);
    }

    /**
     * @param $course
     * @return JsonResponse
     */
    public function getUserCourseReviews($course): JsonResponse
    {
        return response()->json(["data" => $this->reviewsService->getUserReviewsForCourse($course, Auth::id())]);
    }

    /**
     * @param  string  $course
     * @return mixed
     */
    public function allCourseReviews(string $course)
    {
        return CourseStart::where("course_id", $course)
            ->whereNotNull("user_course_started_review_text")
            ->whereNotNull("user_course_started_review_mark")
            ->with('user')
            ->paginate(10);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $courseStartId
     * @return JsonResponse
     */
    public function destroy($courseStartId): JsonResponse
    {
        return response()->json(["data" => $this->reviewsService->removeReview($this->courseStartService->getCourseStartById($courseStartId))]);
    }

}
