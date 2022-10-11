<?php

namespace App\Modules\Sections\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use App\Modules\Sections\Requests\SectionsReorderRequest;
use App\Modules\Sections\Requests\SectionStoreRequest;
use App\Modules\Sections\Requests\SectionUpdateRequest;
use App\Modules\Sections\Services\ISectionsService;
use Illuminate\Http\JsonResponse;

class SectionController extends Controller
{

    /**
     * @var ISectionsService
     */
    private ISectionsService $sectionsService;

    /**
     * @param ISectionsService $sectionsService
     */
    public function __construct(ISectionsService $sectionsService) {
        $this->sectionsService = $sectionsService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SectionStoreRequest $request
     * @return JsonResponse
     */
    public function store(SectionStoreRequest $request): JsonResponse
    {
        return response()->json(["data" => $this->sectionsService->createSection($request->all())]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SectionUpdateRequest $request
     * @param Section $section
     * @return JsonResponse
     */
    public function update(SectionUpdateRequest $request, Section $section): JsonResponse
    {
        return response()->json(["data" => $this->sectionsService->updateSection($request->all(), $section)]);
    }

    /**public function loadSectionsForCourse(Course $course) {
        $course->load(["sections" => function ($query) {
            $query->orderBy('section_order', 'asc');
        }]);
        return response()->json($course->sections, 200);
    }*/

    /**
     * @param SectionsReorderRequest $request
     * @return JsonResponse
     */
    public function sectionsReorder(SectionsReorderRequest $request): JsonResponse
    {
        return response()->json(["data" => $this->sectionsService->reorderSections($request->input("sections"))]);
    }

    public function courseSections(Course $course) {
        $course->load(["sections" => function ($query) {
            $query->orderBy('section_order', 'asc');
        }]);
        return response()->json($course->sections, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Section $section
     * @return JsonResponse
     */
    public function destroy(Section $section): JsonResponse
    {
        $result = $this->sectionsService->deleteSection($section);
        return response()->json(["data" => $result], $result ? 200 : 500);
    }

}
