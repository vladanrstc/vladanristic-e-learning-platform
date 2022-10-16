<?php

namespace App\Modules\Tests\Services;

use App\Models\Test;

interface ITestsService
{

    public function getTestByTestId(int $testId): ?Test;

    public function createOrUpdateTest(string $testName, int $lessonId, string $lang): Test;

    public function updateTest(string $testName, string $lang, Test $test): Test;

    public function deleteTest(Test $test): bool;

    public function checkAnswer($questionId, $answer): array;
}
