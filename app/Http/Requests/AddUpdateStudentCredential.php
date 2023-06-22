<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUpdateStudentCredential extends FormRequest
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
            'student_id' => ['required', 'exists:students,std_ID'],
            'credential_type' => ['required','in:birth_cert,form_137,good_moral,form_138,report_card'],
            'file' => ['required','file']
        ];
    }

    public function messages(){

        return [
            'student_id' => 'Cannot Find the student in the database',
            '*.required' => 'Input is required',
            'file.in' => 'Credential type does not exits'
        ];
    }
}
