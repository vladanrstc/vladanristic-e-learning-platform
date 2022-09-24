<?php

namespace App\Repositories;

use App\Models\Test;

interface ITestsRepo {
    public function createTest(string $testName, string $testDescription, int $lessonId, string $lang): Test;
    public function updateTest(string $testName, string $testDescription, string $lang, Test $test): Test;
    public function deleteTest(Test $test): bool;
}
