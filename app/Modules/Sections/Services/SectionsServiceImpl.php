<?php

namespace App\Modules\Sections\Services;

use App\Models\Section;
use App\Repositories\ISectionsRepo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SectionsServiceImpl implements ISectionsService
{

    /**
     * @var ISectionsRepo
     */
    private ISectionsRepo $sectionsRepo;

    /**
     * @param  ISectionsRepo  $sectionsRepo
     */
    public function __construct(ISectionsRepo $sectionsRepo)
    {
        $this->sectionsRepo = $sectionsRepo;
    }

    /**
     * @param  string  $sectionName
     * @param  int  $sectionCourseId
     * @param  string  $lang
     * @return Section
     */
    public function createSection(string $sectionName, int $sectionCourseId, string $lang): Section
    {

        return DB::transaction(function () use ($sectionName, $sectionCourseId, $lang) {
            $section     = $this->sectionsRepo->createSection($sectionName, $sectionCourseId, $lang);
            $lastSection = $this->sectionsRepo->getLastSectionForCourse($sectionCourseId);

            if (!is_null($lastSection)) {
                return $this->sectionsRepo->updateSection(
                    $section, $sectionName,
                    ($lastSection->{Section::sectionOrder()} + 1), $lang);
            } else {
                return $this->sectionsRepo->updateSection($section, $sectionName, 1, $lang);
            }
        });
    }

    /**
     * @param  array  $sections
     * @return Collection
     */
    public function reorderSections(array $sections): Collection
    {
        return DB::transaction(function () use ($sections) {
            foreach ($sections = \ReorderEntities::reorderEntities($sections, Section::class) as $section) {
                $this->sectionsRepo->updateSection($section, null, $section->{Section::sectionOrder()});
            }
            return $sections;
        });
    }

    /**
     * @param  Section  $section
     * @param  string  $sectionName
     * @param  string  $lang
     * @return Section
     */
    public function updateSection(Section $section, string $sectionName, string $lang): Section
    {
        $section->setTranslation(Section::sectionName(), $lang, $sectionName);
        return $this->sectionsRepo->updateSection($section, $sectionName, null, $lang);
    }

    /**
     * @param  Section  $section
     * @return bool
     */
    public function deleteSection(Section $section): bool
    {
        return $this->sectionsRepo->deleteSection($section);
    }
}
