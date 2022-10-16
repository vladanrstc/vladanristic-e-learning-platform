<?php

namespace App\Modules\Lessons\Requests;

use App\Models\Lesson;
use Illuminate\Foundation\Http\FormRequest;

class LessonAttachVideoRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'lang'              => 'required|max:255',
            'lesson_id'         => 'required|max:255',
            'lesson_video_link' => 'required',
        ];
    }
}
