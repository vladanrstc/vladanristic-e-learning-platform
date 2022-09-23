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

    public function __construct(ILessonFinishService $lessonFinishService) {
        $this->lessonFinishService = $lessonFinishService;
    }

    /**
     * @param Lesson $lesson
     * @return JsonResponse
     */
    public function finishLesson(Lesson $lesson): JsonResponse
    {
        return response()->json(["data" => $this->lessonFinishService->completeLesson($lesson->{Lesson::lessonId()}, Auth::id())]);
    }

}
