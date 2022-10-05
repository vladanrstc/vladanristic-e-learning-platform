<?php

namespace App\Models;

use App\Traits\QuestionAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\Translatable\HasTranslations;

class Question extends Model
{
    use HasTranslations, QuestionAttributes;
    public $translatable = ['question_text'];

    protected $table = 'questions';
    protected $primaryKey = 'question_id';
    protected $guarded = [];
    protected $appends = ["question_type"];

    public function answers() {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function test() {
        return $this->belongsTo(Test::class, "question_id");
    }

    public function getQuestionTypeAttribute() {
        return $this->getQuestionType();
    }

    public function getQuestionType() {

        $answers = Answer::where("question_id", $this->question_id)->get();
        $trigger = 0;
        foreach ($answers as $answer) {

            if($answer->answer_true == 1) {
                $trigger++;
            }

        }
        if($trigger == 1) {
            return "single";
        } else {
            return "multiple";
        }

    }

}
