<?php

namespace App\Repositories;

use App\Models\Section;

interface ISectionsRepo
{
    public function createSection(string $sectionName, int $sectionCourseId, string $lang): Section;

    public function getLastSectionForCourse(int $courseId): Section|null;

    public function updateSection(
        Section $section,
        string $sectionName = null,
        int $sectionOrder = null,
        string $lang = null
    ): Section;

    public function deleteSection(Section $section): bool;
}
