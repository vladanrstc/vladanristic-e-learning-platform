<?php

namespace App\Modules\Lessons\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'lesson_title' => 'required|max:255|min:3',
            'lesson_description' => 'required|max:255|min:3',
            'lesson_code' => 'max:255',
            'lesson_section_id' => 'required',
            'lang' => 'required'
        ];
    }
}
