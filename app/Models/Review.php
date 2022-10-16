<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table      = 'user_courses_started';
    protected $primaryKey = 'user_course_started_id';
    protected $guarded    = [];
}
