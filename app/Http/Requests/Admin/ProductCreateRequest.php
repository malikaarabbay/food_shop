<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            'image' => ['required', 'image', 'max:3000'],
            'title' => ['required', 'max:255'],
            'category_id' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'offer_price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'short_description' => ['required', 'max:200'],
            'description' => ['required'],
            'sku' => ['nullable', 'max:255'],
            'seo_title' => ['nullable', 'max:255'],
            'seo_description' => ['nullable', 'max:255'],
            'show_at_home' => ['boolean'],
            'status' => ['required', 'boolean'],
        ];
    }
}