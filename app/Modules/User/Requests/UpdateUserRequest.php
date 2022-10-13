<?php

namespace App\Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255|min:3',
            'last_name' => 'required|max:1024|min:3',
            'email' => 'required|email|max:1024|min:3',
            'password' => 'sometimes|max:255',
            'role' => 'required|max:1024|min:3'
        ];
    }
}
