<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CoursesRepo implements ICoursesRepo {

    /**
     * @param string $courseName
     * @param string $courseDescription
     * @param $courseImage
     * @param string $lang
     * @return Course
     */
    public function createCourse(string $courseName, string $courseDescription, $courseImage, string $lang): Course {

        return DB::transaction(function() use($courseName, $courseDescription, $courseImage, $lang) {

            $course = new Course();

            $course->setTranslation(Course::courseName(), $lang, $courseName);
            $course->setTranslation(Course::courseDescription(), $lang, $courseDescription);

            $course->{Course::courseSlug()}  = rand(100, 100000) . "-" . Str::slug($courseName, "-");
            $course->{Course::courseImage()} = $courseImage->store('course_photos', 'public');

            $course->save();

            return $course;

        });

    }

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
