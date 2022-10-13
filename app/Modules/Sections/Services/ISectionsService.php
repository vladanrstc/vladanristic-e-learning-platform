<?php

namespace App\Modules\Sections\Services;

use App\Models\Section;
use Illuminate\Support\Collection;

interface ISectionsService
{
    public function createSection(string $sectionName, int $sectionCourseId, string $lang): Section;

    public function updateSection(Section $section, string $sectionName, string $lang): Section;

    public function reorderSections(array $sections): Collection;

    public function deleteSection(Section $section): bool;
}
