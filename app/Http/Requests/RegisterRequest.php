<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => 'required|string:max:20,min:4',
            'phone' => 'required|phone:INTERNATIONAL',
        ];
    }

    public function messages(): array
    {
        return [
            'phone' => 'The :attribute field must be a valid number.'
        ];
    }
}
