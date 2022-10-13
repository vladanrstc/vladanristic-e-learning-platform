<?php

namespace App\Traits;

trait AnswerAttributes
{

    public static function answerText()
    {
        return "answer_text";
    }

    public static function isAnswerCorrect()
    {
        return "answer_true";
    }

    public static function questionId()
    {
        return "question_id";
    }

}
