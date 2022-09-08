<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseStart extends Model
{
    protected $table = 'user_courses_started';
    protected $primaryKey = 'user_course_started_id';

    public function lessons_completed() {
        return $this->hasMany(LessonCompleted::class);
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
