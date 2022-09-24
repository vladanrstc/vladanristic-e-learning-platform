<?php

namespace App\Enums;

enum Modules: string
{
    case AUTH         = "Auth";
    case ROOT         = "Root";
    case COURSE       = "Course";
    case USER         = "User";
    case COURSE_START = "CourseStart";
    case LESSONS      = "Lessons";
    case NOTES        = "Notes";
    case REVIEWS      = "Reviews";
    case SECTIONS     = "Sections";
    case STATS        = "Stats";
    case QUESTIONS    = "Questions";
}
