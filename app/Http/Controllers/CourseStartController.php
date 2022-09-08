<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseStart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CourseStartController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        request()->validate([
            'course_id' => 'required'
        ]);

        $course_started = new CourseStart();
        $course_started->course_id = $request->course_id;
        $course_started->user_id = Auth::id();
        $course_started->save();

        return response()->json("success", 200);

    }

    // get courses that user hasn't started
    public function courses_not_started() {
        $user = Auth::user();
        return Course::whereDoesntHave('courses_started', function (Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        })->orderBy('created_at', 'desc')->get();
    }

    // get courses that user started
    public function courses_started() {
        $user = Auth::user();
        return Course::whereHas('courses_started', function (Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        })->orderBy('created_at', 'desc')->get();
    }

}
