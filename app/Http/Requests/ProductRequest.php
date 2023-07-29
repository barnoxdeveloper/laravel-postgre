<?php

namespace App\Http\Requests;

use App\Helpers\ResponseFormatter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $productId = $this->route('products'); // Get the user ID from the route parameter

        return [
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => $this->isMethod('put')
                ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048,' . $productId
                : 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Unique for update, but required for create
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return ResponseFormatter::error(
            ['error' => $validator->errors()],
            'Validation Error!',
            422
        );
    }
}
