<?php

namespace App\Models;

use App\Traits\TestAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\Translatable\HasTranslations;

class Test extends Model
{
    use HasTranslations, TestAttributes;

    public $translatable = ['test_name'];

    protected $table      = 'tests';
    protected $primaryKey = 'test_id';
    protected $guarded    = [];
    protected $appends    = ['meets_requirements'];

    public function questions()
    {
        return $this->hasMany(Question::class, "test_id");
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, "lesson_id");
    }

    public function getMeetsRequirementsAttribute()
    {
        return $this->getTestStatus();
    }

    public function getTestStatus()
    {

        $test_flag = true;
        $questions = Question::where(Question::testId(), $this->test_id)->get();

        if (!is_null($questions) && count($questions) == 0) {
            return false;
        }

        foreach ($questions as $question) {

            $question_flag = false;
            foreach ($question->answers as $answer) {

                if ($answer->answer_true) {
                    $question_flag = true;
                    break;
                }
            }

            if (!$question_flag) {
                $test_flag = false;
                break;
            }

        }
        return $test_flag;
    }

}
