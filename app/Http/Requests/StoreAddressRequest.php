<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'street' => 'required|string|min:10|max:255',
            'number' => 'required|integer|min:1',
            'zip' => 'required|string|min:8|max:15',
            'city' => 'required|string|min:4|max:20',
            'state' => 'required|string|min:4|max:20',
            'country' => 'required|string|min:4|max:20'
        ];
    }
}
