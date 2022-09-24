<?php

namespace App\Modules\Sections\Services;

use App\Models\Section;
use Illuminate\Support\Collection;

interface ISectionsService {
    public function createSection(array $params): Section;
    public function updateSection(array $params, Section $section): Section;
    public function reorderSections(array $sections): Collection;
    public function deleteSection(Section $section): bool;
}
