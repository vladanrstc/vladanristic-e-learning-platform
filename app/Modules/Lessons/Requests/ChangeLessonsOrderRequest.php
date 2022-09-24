<?php

namespace App\Modules\Lessons\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeLessonsOrderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'lessons' => 'required|max:255|min:3',
        ];
    }
}
