<?php

namespace App\Repositories;

use App\Models\Question;

class QuestionsRepo implements IQuestionsRepo {

    /**
     * @param string $questionText
     * @param int $testId
     * @param string $lang
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
     * @param string $questionText
     * @param string $lang
     * @param Question $question
     * @return Question
     */
    public function updateQuestion(string $questionText, string $lang, Question $question): Question
    {
        $question->setTranslation(Question::questionText(), $lang, $questionText);
        $question->save();
        return $question;
    }

    /**
     * @param Question $question
     * @return bool
     */
    public function deleteQuestion(Question $question): bool
    {
        if($question->delete()) {
            return true;
        }
        return false;
    }
}
