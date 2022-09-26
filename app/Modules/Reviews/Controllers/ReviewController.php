<?php

namespace App\Modules\Reviews\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CourseStart;
use App\Modules\Notes\Requests\UpdateCourseReviewRequest;
use App\Modules\Reviews\Services\IReviewsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    /**
     * @var IReviewsService
     */
    private IReviewsService $reviewsService;

    public function __construct(IReviewsService $reviewsService) {
        $this->reviewsService = $reviewsService;
    }

    /**
     * @param string $courseSlug
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
     * @param UpdateCourseReviewRequest $request
     * @return JsonResponse
     */
    public function updateCourseReview(UpdateCourseReviewRequest $request): JsonResponse
    {
        return response()->json(["data" => $this->reviewsService->updateCourseStartReview(
            $request->input("course"),
            $request->input("review"),
            $request->input("rating"),
            Auth::id()
        )]);
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
     * Remove the specified resource from storage.
     *
     * @param CourseStart $courseStart
     * @return JsonResponse
     */
    public function destroy(CourseStart $courseStart): JsonResponse
    {
        return response()->json(["data" => $this->reviewsService->removeReview($courseStart)]);
    }

}
