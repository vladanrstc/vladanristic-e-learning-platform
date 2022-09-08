<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{

    use HasTranslations;
    public $translatable = ['section_name'];

    protected $table = 'sections';
    protected $primaryKey = 'section_id';
    protected $guarded = [];

    public function lessons() {
        return $this->hasMany(Lesson::class, "lesson_section_id");
    }

    public function course() {
        return $this->belongsTo(Course::class, 'course_id');
    }

}
