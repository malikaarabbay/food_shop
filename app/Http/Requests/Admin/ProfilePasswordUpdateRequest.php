<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePasswordUpdateRequest extends FormRequest
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
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'max:5', 'confirmed']
        ];
    }

    function messages() : array
    {
        return [
            'current_password.current_password' => 'Current password is invalid!',
        ];
    }
}
