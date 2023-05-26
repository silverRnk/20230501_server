<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
class AddTeacherRequest extends FormRequest
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
    
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'addr_line1' => ['required', 'string'],
            'addr_line2' => ['string', 'nullable', ],
            'gender' => ['required','in:male,female'],
            'date_of_birth' => ['required', 'date'],
            'religion' => ['string', 'nullable'],
            'email' => ['required', 'email',
             'unique:teachers,email'],
            'phone_no' => ['required', 'numeric'],
            'advisory_class' => ['string', 'nullable'],
            'profile_img' => ['file', 'image', 'max:1024', 'nullable'],
            'password' => [Password::min(6), 'required', 'confirmed']
        ];
    }

    public function messages(){

        return [
            '*.required' => 'Input is required',
            'gender.in' => 'Input must be either male or female',
            'email.unique' => 'Email already exists',
            'email.required' => 'Input is required',
            'password.min' => 'Input must be minimum of 6 character',
            'password.confirmed' => 'Confirm your password',
            'profile_img.max' => 'Maximum image size must be less than 1Mb',
            'profile_img.image' => 'File must be an image',
            'profile_img.file' => 'Uploaded must be a file and an image'
        ];
    }

}
