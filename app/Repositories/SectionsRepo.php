<?php

namespace App\Repositories;

use App\Exceptions\SectionUpdateFailedException;
use App\Models\Section;

class SectionsRepo implements ISectionsRepo
{

    /**
     * @param  string  $sectionName
     * @param  int  $sectionCourseId
     * @param  string  $lang
     * @return Section
     */
    public function createSection(string $sectionName, int $sectionCourseId, string $lang): Section
    {
        $section = new Section();
        $section->setTranslation(Section::sectionName(), $lang, $sectionName);
        $section->{Section::sectionCourseId()} = $sectionCourseId;
        return $section;
    }

    /**
     * @param  int  $courseId
     * @return Section|null
     */
    public function getLastSectionForCourse(int $courseId): Section|null
    {
        return Section::where(Section::sectionCourseId(), $courseId)
            ->orderBy(Section::sectionOrder(), "desc")
            ->first();
    }

    /**
     * @param  Section  $section
     * @param  string|null  $sectionName
     * @param  int|null  $sectionOrder
     * @param  string|null  $lang
     * @return Section
     * @throws SectionUpdateFailedException
     */
    public function updateSection(
        Section $section,
        string $sectionName = null,
        int $sectionOrder = null,
        string $lang = null
    ): Section {

        !is_null($sectionName) ? $section->setTranslation(Section::sectionName(), $lang, $sectionName) : false;

        !is_null($sectionOrder) ? $section->{Section::sectionOrder()} = $sectionOrder : false;

        if ($section->save()) {
            return $section;
        }

        throw new SectionUpdateFailedException();
    }

    /**
     * @param  Section  $section
     * @return bool
     */
    public function deleteSection(Section $section): bool
    {
        if ($section->delete()) {
            return true;
        }
        return false;
    }

}
