<?php

namespace App\Repositories;

use App\Models\Answer;

interface IAnswersRepo
{
    public function createAnswer(string $answerText, int $questionId, bool $isAnswerCorrect, string $lang): Answer;

    public function updateAnswer(string $answerText, bool $isAnswerCorrect, string $lang, Answer $answer): Answer;

    public function deleteAnswer(Answer $answer): bool;
}
