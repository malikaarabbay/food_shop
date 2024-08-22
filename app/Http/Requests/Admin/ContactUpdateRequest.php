<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'phone_one' => ['nullable', 'max:50'],
            'phone_two' => ['nullable', 'max:50'],
            'mail_one' => ['nullable', 'max:255'],
            'mail_two' => ['nullable', 'max:255'],
            'address' => ['nullable', 'max:1000'],
            'map_link' => ['nullable'],

        ];
    }
}
