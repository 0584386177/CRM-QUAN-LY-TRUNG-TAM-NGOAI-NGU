<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'fullname' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:12'],
            'birthday' => ['required'],
            'hire_date' => ['required'],
            'teacher_type' => ['required'],
            'status' => ['required', 'not_in:0'],
            'base_salary' => ['required'],
            'bio' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'password' => ['string', 'min:8'],
            're_password' => ['string', 'same:password', 'min:8'],
        ];
    }
}
