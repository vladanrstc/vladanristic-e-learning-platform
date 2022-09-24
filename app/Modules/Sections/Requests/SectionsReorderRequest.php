<?php

namespace App\Modules\Sections\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionsReorderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'sections' => 'required|array'
        ];
    }
}
