<?php

namespace App\Modules\Questions\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'lang'                                            => 'required|max:255|min:3',
            'question_text.'.$this->request->get("lang") => 'required|max:255|min:3'
        ];
    }
}
