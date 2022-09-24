<?php

namespace App\Modules\Questions\Services;

use App\Models\Question;

interface IQuestionsService {
    public function createQuestion(string $questionText, int $testId, string $lang): Question;
    public function updateQuestion(string $questionText, string $lang, Question $question): Question;
    public function deleteQuestion(Question $question): bool;
}
