<?php

namespace App\Http\Requests\Moderator;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'categoryId' => 'required|exists:categories,id|integer',
            'name' => 'required|string|min:3|max:255|unique:products,name',
            'stock' => 'required|integer|min:1|max:255',
            'price'=> 'required|decimal:2|min:1',
            'image' => 'required|image'
        ];
    }
}
