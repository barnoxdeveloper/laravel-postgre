<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $userId = $this->route('user'); // Get the user ID from the route parameter

        return [
            'name' => 'required|string|max:255',
            'email' => $this->isMethod('put')
                ? 'required|email|unique:users,email,' . $userId
                : 'required|email|unique:users,email', // Unique for update, but required for create
            'password' => $this->isMethod('put') ? 'sometimes|string|min:8' : 'required|string|min:8',
        ];
    }
}
