<?php

namespace App\Models;

use App\Traits\CourseStartAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseStart extends Model
{

    use CourseStartAttributes;

    protected $table      = 'user_courses_started';
    protected $primaryKey = 'user_course_started_id';
    protected $guarded    = [];

    public function lessonsCompleted() {
        return $this->hasMany(LessonCompleted::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, "course_id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

}
