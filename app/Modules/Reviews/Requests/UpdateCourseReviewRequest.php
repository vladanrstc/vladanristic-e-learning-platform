<?php

namespace App\Modules\Reviews\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseReviewRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'course'  => 'required|max:255',
            'review'  => 'required|max:1024',
            'rating'  => 'required|max:1024'
        ];
    }
}
