<?php

namespace App\Http\Controllers;

use App\Models\Lesson;

class HomeController extends Controller
{

    public function last_three_videos() {
        return Lesson::orderBy("created_at", "desc")
            ->whereNotNull("lesson_video_link")
            ->take(3)
            ->get();
    }

}
