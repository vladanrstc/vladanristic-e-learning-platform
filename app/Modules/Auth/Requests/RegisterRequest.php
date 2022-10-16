<?php

namespace App\Modules\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'      => 'required|max:255|min:3',
            'last_name' => 'required|max:255|min:3',
            'email'     => 'required|email|max:255|min:3',
            'password'  => 'required|max:255|min:3',
            'language'  => 'required|max:255|min:2',
        ];
    }
}
