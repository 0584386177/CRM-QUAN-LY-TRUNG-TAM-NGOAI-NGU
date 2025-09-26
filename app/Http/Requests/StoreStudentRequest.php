<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'phone' => ['required', 'min:10'],
            'birthday' => ['required'],
            'address' => ['required'],
            'avatar' => ['nullable'],
            'course_id' => ['required'],
            'teacher_id' => ['required'],
            'class_id' => ['required'],
            'fee_amount' => ['nullable'],
            'paid_amount' => ['nullable'],
            'remaining' => ['nullable'],
        ];
    }
}
