<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockProductRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'id' => 'required|string',
            'quantity' => 'required|integer',
            'type' => 'required|string|in:increment,decrement',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'id.required' => 'The product ID is required.',
            'id.integer' => 'The product ID must be an integer.',
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'type.required' => 'The adjustment type is required.',
            'type.in' => 'The adjustment type must be either "increase" or "decrease".',
        ];
    }
}
