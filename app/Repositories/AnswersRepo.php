<?php

namespace App\Repositories;

use App\Models\Answer;

class AnswersRepo implements IAnswersRepo
{

    /**
     * @param string $answerText
     * @param int $questionId
     * @param bool $isAnswerCorrect
     * @param string $lang
     * @return Answer
     */
    public function createAnswer(string $answerText, int $questionId, bool $isAnswerCorrect, string $lang): Answer
    {
        $answer = new Answer();
        $answer->setTranslation(Answer::answerText(), $lang, $answerText);
        $answer->{Answer::questionId()} = $questionId;
        $answer->{Answer::isAnswerCorrect()} = $isAnswerCorrect;
        $answer->save();
        return $answer;
    }

    /**
     * @param string $answerText
     * @param bool $isAnswerCorrect
     * @param string $lang
     * @param Answer $answer
     * @return Answer
     */
    public function updateAnswer(string $answerText, bool $isAnswerCorrect, string $lang, Answer $answer): Answer {
        $answer->setTranslation(Answer::answerText(), $lang, $answerText);
        $answer->{Answer::isAnswerCorrect()} = $isAnswerCorrect;
        $answer->save();
        return $answer;
    }

    public function deleteAnswer(Answer $answer): bool
    {
        if($answer->delete()) {
            return true;
        }
        return false;
    }
}
