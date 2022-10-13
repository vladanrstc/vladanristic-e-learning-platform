<?php

namespace App\Modules\Notes\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseNoteRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'course' => 'required|max:255|min:3',
            'notes' => 'required|max:1024|min:3'
        ];
    }
}
