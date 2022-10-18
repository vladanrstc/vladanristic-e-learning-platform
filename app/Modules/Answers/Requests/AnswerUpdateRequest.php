<?php

namespace App\Modules\Answers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'lang'                                       => 'required',
            'answer_text.' . $this->request->get("lang") => 'required|max:255|min:3',
            'answer_true'                                => 'required',
        ];
    }
}
