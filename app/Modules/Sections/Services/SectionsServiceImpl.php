<?php

namespace App\Modules\Sections\Services;

use App\Models\Section;
use App\Repositories\ISectionsRepo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SectionsServiceImpl implements ISectionsService {

    /**
     * @var ISectionsRepo
     */
    private ISectionsRepo $sectionsRepo;

    /**
     * @param ISectionsRepo $sectionsRepo
     */
    public function __construct(ISectionsRepo $sectionsRepo) {
        $this->sectionsRepo = $sectionsRepo;
    }

    /**
     * @param array $params
     * @return Section
     */
    public function createSection(array $params): Section
    {

        return DB::transaction(function() use($params) {
            $section     = $this->sectionsRepo->createSection($params);
            $lastSection = $this->sectionsRepo->getLastSectionForCourse($params[Section::sectionCourseId()]);

            if(!is_null($lastSection)) {
                return $this->sectionsRepo->updateSection([Section::sectionOrder() => $lastSection->{Section::sectionOrder()} + 1], $section);
            } else {
                return $this->sectionsRepo->updateSection([Section::sectionOrder() => 1], $section);
            }

        });
    }

    /**
     * @param array $params
     * @param Section $section
     * @return Section
     */
    public function updateSection(array $params, Section $section): Section
    {
        $section->setTranslation('section_name', $params['lang'], $params[Section::sectionName()][$params['lang']]);
        return $this->sectionsRepo->updateSection([], $section);
    }

    /**
     * @param array $sections
     * @return Collection
     */
    public function reorderSections(array $sections): Collection
    {
        DB::transaction(function() use ($sections) {
            $count = 1;
            $sections = Section::hydrate($sections);
            foreach ($sections as $section) {
                $this->updateSection([Section::sectionOrder() => $count], $section);
                $count++;
            }
            return $sections;
        });
    }

    /**
     * @param Section $section
     * @return bool
     */
    public function deleteSection(Section $section): bool
    {
        return $this->sectionsRepo->deleteSection($section);
    }
}
