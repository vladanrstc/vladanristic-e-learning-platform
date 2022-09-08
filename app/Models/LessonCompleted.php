<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonCompleted extends Model
{

    protected $table = 'lessons_completed';
    protected $primaryKey = 'lesson_completed_id';
    protected $guarded = [];

    public function lesson() {
        return $this->belongsTo(Lesson::class);
    }

    public function course_started() {
        return $this->belongsTo(CourseStart::class);
    }

}
