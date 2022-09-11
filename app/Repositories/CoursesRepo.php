<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Support\Collection;

class CoursesRepo implements ICoursesRepo {

    /**
     * @param string $courseSlug
     * @return Course|null
     */
    public function getCourseForSlug(string $courseSlug): Course|null {
        return Course::where(Course::courseSlug(), $courseSlug)
            ->with(["sections" => function ($query) {
                $query->orderBy(Section::sectionOrder(), "ASC");
            },
                "sections.lessons" => function ($query) {
                    $query->where(Lesson::lessonPublished(), "1")
                        ->orderBy(Lesson::lessonOrder(), "ASC");
                },
                "sections.lessons.test"
            ])
            ->first();
    }

    /**
     * @return Collection
     */
    public function getAllCourses(): Collection
    {
        return Course::all();
    }

    /**
     * @param Course $course
     * @return bool
     */
    public function deleteCourse(Course $course): bool
    {
        if($course->delete()) {
            return true;
        }
        return false;
    }
}
