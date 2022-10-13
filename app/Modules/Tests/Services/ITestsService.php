<?php

namespace App\Modules\Tests\Services;

use App\Models\Test;

interface ITestsService
{
    public function createTest(string $testName, string $testDescription, int $lessonId, string $lang): Test;

    public function updateTest(string $testName, string $testDescription, string $lang, Test $test): Test;

    public function deleteTest(Test $test): bool;

    public function checkAnswer($questionId, $answer): array;
}
