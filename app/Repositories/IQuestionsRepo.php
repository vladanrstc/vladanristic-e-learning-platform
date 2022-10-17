<?php

namespace App\Repositories;

use App\Models\Question;
use Illuminate\Support\Collection;

interface IQuestionsRepo
{
    public function getQuestionById(int $questionId): ?Question;

    public function getQuestionByIdWithCorrectAnswers(int $questionId): ?Question;

    public function createQuestion(string $questionText, int $testId, string $lang): Question;

    public function updateQuestion(string $questionText, string $lang, Question $question): Question;

    public function deleteQuestion(Question $question): bool;

    public function getTestQuestions(int $testId): ?Collection;
}
