<?php

namespace App\Modules\CourseStart\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Modules\Coursestart\Services\ILessonFinishService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LessonCompletedController extends Controller
{

    /**
     * @var ILessonFinishService
     */
    private ILessonFinishService $lessonFinishService;

    public function __construct(ILessonFinishService $lessonFinishService)
    {
        $this->lessonFinishService = $lessonFinishService;
    }

    /**
     * @param $lessonId
     * @return JsonResponse
     */
    public function finishLesson($lessonId): JsonResponse
    {
        return response()->json(["data" => $this->lessonFinishService->completeLesson($lessonId, Auth::id())]);
    }

}
