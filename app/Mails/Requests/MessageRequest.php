<?php

namespace App\Mails\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'message'   => 'required|max:255|min:3',
        ];
    }
}
