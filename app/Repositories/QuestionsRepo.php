<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Support\Collection;

class QuestionsRepo implements IQuestionsRepo
{

    /**
     * @param  int  $testId
     * @return Collection|null
     */
    public function getTestQuestions(int $testId): ?Collection
    {
        return Question::where(Test::testId(), $testId)
            ->with('answers')
            ->get();
    }

    /**
     * @param  int  $questionId
     * @return Question|null
     */
    public function getQuestionById(int $questionId): ?Question
    {
        return Question::where(Question::questionId(), $questionId)
            ->first();
    }

    /**
     * @param  int  $questionId
     * @return Question|null
     */
    public function getQuestionByIdWithCorrectAnswers(int $questionId): ?Question
    {
        return Question::where(Question::questionId(), $questionId)
            ->with([
                "answers" => function ($query) {
                    $query->where(Answer::isAnswerCorrect(), 1);
                }
            ])
            ->first();
    }

    /**
     * @param  string  $questionText
     * @param  int  $testId
     * @param  string  $lang
     * @return Question
     */
    public function createQuestion(string $questionText, int $testId, string $lang): Question
    {
        $question = new Question();
        $question->setTranslation(Question::questionText(), $lang, $questionText);
        $question->{Question::testId()} = $testId;
        $question->save();
        return $question;
    }

    /**
     * @param  string  $questionText
     * @param  string  $lang
     * @param  Question  $question
     * @return Question
     */
    public function updateQuestion(string $questionText, string $lang, Question $question): Question
    {
        $question->setTranslation(Question::questionText(), $lang, $questionText);
        $question->save();
        return $question;
    }

    /**
     * @param  Question  $question
     * @return bool
     */
    public function deleteQuestion(Question $question): bool
    {
        if ($question->delete()) {
            return true;
        }
        return false;
    }
}
