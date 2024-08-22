<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class AddressCreateRequest extends FormRequest
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
            'delivery_id' => ['required', 'integer'],
            'lastname' => ['nullable', 'max:255'],
            'firstname' => ['required', 'max:255'],
            'phone' => ['required', 'max:60'],
            'email' => ['required', 'email'],
            'address' => ['required'],
            'type' => ['required', 'in:home,office'],
        ];
    }
}
