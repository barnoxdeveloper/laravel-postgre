<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Helpers\ResponseFormatter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
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
        $userId = $this->route('users'); // Get the user ID from the route parameter

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->route('user')),
            ],
            // 'email' => 'required|email|max:255',
            // 'password' => 'required|max:255',
            // 'email' => $this->isMethod('PUT')
            //     ? 'required|email|unique:users,email,' . $userId
            //     : 'required|email|unique:users,email', // Unique for update, but required for create
            'password' => $this->isMethod('put') ? 'sometimes|string|min:8' : 'required|string|min:8',
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
