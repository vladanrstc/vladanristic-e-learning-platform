<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Answer extends Model
{
    use HasTranslations;
    public $translatable = ['answer_text'];

    protected $table = 'answers';
    protected $primaryKey = 'answer_id';
    protected $guarded = [];

    /*public function question() {
        return $this->hasMany("App\Answer");
    }*/

    public function question() {
        return $this->belongsTo(Question::class, "question_id");
    }

}
