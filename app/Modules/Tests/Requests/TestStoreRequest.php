<?php

namespace App\Modules\Tests\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'lang'                                     => 'required',
            'test_name.' . $this->request->get("lang") => 'required|max:255|min:3',
            'lesson_id'                                => 'required',
        ];
    }
}
