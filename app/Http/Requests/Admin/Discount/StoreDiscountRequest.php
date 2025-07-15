<?php

namespace App\Http\Requests\Admin\Discount;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
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
            'description' => 'string|min:3|max:255',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'discountPercentage' => 'required|decimal:2|min:1|max:255',
            'productId' => 'sometimes|exists:products,id'
        ];
    }
}
