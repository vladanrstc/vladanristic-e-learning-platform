<?php

namespace App\Models;

use App\Traits\SectionAttributes;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;
use Spatie\Translatable\HasTranslations;

class Section extends Model implements Orderable
{

    use HasTranslations, SectionAttributes;

    public $translatable = ['section_name'];

    protected $table      = 'sections';
    protected $primaryKey = 'section_id';
    protected $guarded    = [];

    public function lessons()
    {
        return $this->hasMany(Lesson::class, "lesson_section_id");
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * @return string
     */
    public function getOrderColumnName(): string
    {
        return self::sectionOrder();
    }
}
