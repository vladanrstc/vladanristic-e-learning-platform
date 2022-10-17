<?php

namespace App\Modules\Questions\Services;

use App\Models\Question;
use App\Repositories\IQuestionsRepo;
use Illuminate\Support\Collection;

class QuestionsServiceImpl implements IQuestionsService
{

    /**
     * @var IQuestionsRepo
     */
    private IQuestionsRepo $questionsRepo;

    /**
     * @param  IQuestionsRepo  $questionsRepo
     */
    public function __construct(IQuestionsRepo $questionsRepo)
    {
        $this->questionsRepo = $questionsRepo;
    }

    /**
     * @param  string  $questionText
     * @param  int  $testId
     * @param  string  $lang
     * @return Question
     */
    public function createQuestion(string $questionText, int $testId, string $lang): Question
    {
        return $this->questionsRepo->createQuestion($questionText, $testId, $lang);
    }

    /**
     * @param  string  $questionText
     * @param  string  $lang
     * @param  Question  $question
     * @return Question
     */
    public function updateQuestion(string $questionText, string $lang, Question $question): Question
    {
        return $this->questionsRepo->updateQuestion($questionText, $lang, $question);
    }

    /**
     * @param  Question  $question
     * @return bool
     */
    public function deleteQuestion(Question $question): bool
    {
        return $this->questionsRepo->deleteQuestion($question);
    }

    /**
     * @param  int  $testId
     * @return Collection|null
     */
    public function getTestQuestions(int $testId): ?Collection
    {
        return $this->questionsRepo->getTestQuestions($testId);
    }
}
