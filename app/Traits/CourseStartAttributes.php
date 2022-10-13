<?php

namespace App\Traits;

trait CourseStartAttributes
{

    public static function courseStartedId()
    {
        return "user_course_started_id";
    }

    public static function userId()
    {
        return "user_id";
    }

    public static function courseId()
    {
        return "course_id";
    }

    public static function courseStartNote()
    {
        return "user_course_started_note";
    }

    public static function courseStartReview()
    {
        return "user_course_started_review_text";
    }

    public static function courseStartMark()
    {
        return "user_course_started_review_mark";
    }

}
