<?php

namespace App\Modules\Answers\Services;

use App\Models\Answer;
use App\Repositories\IAnswersRepo;

class AnswersServiceImpl implements IAnswersService {

    /**
     * @var IAnswersRepo
     */
    private IAnswersRepo $answersRepo;

    /**
     * @param IAnswersRepo $answersRepo
     */
    public function __construct(IAnswersRepo $answersRepo) {
        $this->answersRepo = $answersRepo;
    }

    /**
     * @param string $answerText
     * @param int $questionId
     * @param bool $isAnswerCorrect
     * @param string $lang
     * @return Answer
     */
    public function createAnswer(string $answerText, int $questionId, bool $isAnswerCorrect, string $lang): Answer
    {
        return $this->answersRepo->createAnswer($answerText, $questionId, $isAnswerCorrect, $lang);
    }

    /**
     * @param string $answerText
     * @param bool $isAnswerCorrect
     * @param string $lang
     * @param Answer $answer
     * @return Answer
     */
    public function updateAnswer(string $answerText, bool $isAnswerCorrect, string $lang, Answer $answer): Answer
    {
        return $this->answersRepo->updateAnswer($answerText, $isAnswerCorrect, $lang, $answer);
    }

    /**
     * @param Answer $answer
     * @return Answer
     */
    public function deleteAnswer(Answer $answer): Answer
    {
        // TODO: Implement deleteAnswer() method.
    }
}
