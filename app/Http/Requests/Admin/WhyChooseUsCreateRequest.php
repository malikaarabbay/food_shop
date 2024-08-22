<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WhyChooseUsCreateRequest extends FormRequest
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
            'icon' => ['required', 'max:50'],
            'title' => ['required', 'max:255'],
            'short_description' => ['required', 'max:500'],
            'status' => ['required', 'boolean']
        ];
    }
}
