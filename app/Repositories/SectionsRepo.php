<?php

namespace App\Repositories;

use App\Exceptions\SectionUpdateFailedException;
use App\Models\Course;
use App\Models\Section;

class SectionsRepo implements ISectionsRepo {

    /**
     * @param array $params
     * @return Section
     */
    public function createSection(array $params): Section
    {
        return Section::create($params);
    }

    /**
     * @param int $courseId
     * @return Section
     */
    public function getLastSectionForCourse(int $courseId): Section
    {
        return Section::where(Section::sectionCourseId(), $courseId)
            ->orderBy(Section::sectionOrder(), "desc")
            ->first();
    }

    /**
     * @param array $updateParams
     * @param Section $section
     * @return Section
     * @throws SectionUpdateFailedException
     */
    public function updateSection(array $updateParams, Section $section): Section
    {
        if($section->update($updateParams)) {
            return $section;
        }
        throw new SectionUpdateFailedException();
    }

    /**
     * @param Section $section
     * @return bool
     */
    public function deleteSection(Section $section): bool {
        if($section->delete()) {
            return true;
        }
        return false;
    }


}
