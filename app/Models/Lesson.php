<?php

namespace App\Models;

use App\Traits\LessonAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\Pure;
use Spatie\Translatable\HasTranslations;

class Lesson extends Model implements Orderable
{
    use HasTranslations, LessonAttributes;

    public $translatable = ['lesson_title', 'lesson_description', 'lesson_practice', 'lesson_video_link'];

    protected $table      = 'lessons';
    protected $primaryKey = 'lesson_id';
    protected $guarded    = [];
    protected $appends    = ['lesson_completed'];

    public function lessonsCompleted()
    {
        return $this->hasMany(LessonCompleted::class, "lesson_completed_id");
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'lesson_test_id');
    }

    public function getLessonCompletedAttribute()
    {
        return $this->getLessonCompleted();
    }

    public function getLessonCompleted()
    {

        $section = Section::where(Section::sectionId(), $this->lesson_section_id)->first();
        $course  = Course::where(Course::courseId(), $section->section_course_id)->first();

        $course_started = CourseStart::where("course_id", $course->course_id)
            ->where("user_id", Auth::id())
            ->first();

        if (is_null($course_started)) {
            return false;
        }

        return !is_null(
            LessonCompleted::where(Lesson::lessonId(), $this->lesson_id)
                ->where("course_started_id", $course_started->user_course_started_id)
                ->first());

    }

    /**
     * @return string
     */
    public function getOrderColumnName(): string
    {
        return self::lessonOrder();
    }
}
