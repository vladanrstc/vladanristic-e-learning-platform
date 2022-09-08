<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseStart;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->user_course_started_review_text = null;
        $review->user_course_started_review_mark = null;
        $review->save();
        return response()->json("success", 200);
    }

    public function course_reviews($course) {
        return CourseStart::where("course_id", $course)
            ->whereNotNull("user_course_started_review_text")
            ->whereNotNull("user_course_started_review_mark")
            ->with('user')->paginate(10);
    }

    public function course_reviews_user($course) {
        $course = Course::where("course_slug", "like", $course)->first();
        return CourseStart::where("course_id", $course->course_id)
            ->whereNotNull("user_course_started_review_mark")
            ->with('user')
            ->paginate(6);
    }

    public function update_course_review(Request $request) {
        $course = Course::where("course_slug", "like", $request->course)->first();
        $started_course = CourseStart::where("course_id", $course->course_id)->where("user_id", Auth::id())->first();
        $started_course->user_course_started_review_text = $request->review;
        $started_course->user_course_started_review_mark = $request->rating;
        $started_course->save();
        return response()->json("success", 200);
    }

    public function get_course_review($course) {
        $course = Course::where("course_slug", "like", $course)->first();
        return CourseStart::where("course_id", $course->course_id)->where("user_id", Auth::id())->first();
    }

}
