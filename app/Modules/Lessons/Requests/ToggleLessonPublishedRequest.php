<?php

namespace App\Modules\Lessons\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToggleLessonPublishedRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'lesson_id' => 'required|max:255|min:3',
            'lesson_published' => 'required|max:255|min:3',
        ];
    }
}
