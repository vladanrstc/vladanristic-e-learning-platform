<?php

namespace App\Modules\Course\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'course_name'        => 'required|max:255|min:3',
            'course_description' => 'required|max:1024|min:3',
            'course_image'       => 'image',
            'lang'               => 'required'
        ];
    }
}
