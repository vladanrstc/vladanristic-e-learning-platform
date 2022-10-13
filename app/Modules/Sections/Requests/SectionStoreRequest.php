<?php

namespace App\Modules\Sections\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'section_name.'.$this->request->get("lang") => 'required|max:255|min:3',
            'section_course_id' => 'required'
        ];
    }
}
