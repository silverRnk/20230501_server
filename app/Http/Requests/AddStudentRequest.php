<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class AddStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    //failure point
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'std_first_name' => 'required|string',
            'std_last_name' => 'required|string',
            'std_gender' => ['required','in:male,female'],
            'std_date_of_birth' => ['required', 'date'],
            'std_religion' => ['string'],
            'std_phone' => ['required', 'numeric'],
            'std_email' => 'required|email|unique:students,std_email',
            'std_password' => ['required', 'confirmed',
            Password::min(6)
            ->letters()],
            'std_grade' => ['required', 'string'],
            'std_section' => ['required', 'string'],
            'std_photo' => ['file','image','nullable', 'max:1024'],

            'fathers_name' => ['required', 'string'],
            'mothers_name' => ['required', 'string'],
            'fathers_occupation' => ['required', 'string'],
            'parents_religion' => ['required', 'string'],
            'parents_email' => ['required', 'email', 'string'],
            'parents_phone' => ['required']
        ];
    }
}

