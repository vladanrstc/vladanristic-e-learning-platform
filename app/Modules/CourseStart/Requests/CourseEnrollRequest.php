<?php

namespace App\Modules\CourseStart\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseEnrollRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'course_id' => 'required|max:255|min:1'
        ];
    }
}
