<?php

namespace App\Repositories;

use App\Models\Section;

interface ISectionsRepo {
    public function createSection(array $params): Section;
    public function getLastSectionForCourse(int $courseId): Section;
    public function updateSection(array $updateParams, Section $section): Section;
    public function deleteSection(Section $section): bool;
}
