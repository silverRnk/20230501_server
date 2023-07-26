<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
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
             'first_name'=> ['string', 'required'] ,
             'last_name'=> ['string', 'required'],
             'date_of_birth'=> ['date', ],
             'gender'=> ['string', 'in:Male,Female,male,female', 'required'],
             'address'=> ['string', 'required'],
             'place_of_birth'=> ['string', 'required'],
             'enrollee_type' => ['string', 'required', 'in:old,new,transferee'],
             'prev_school'=> ['string', 'required_if:enrollee_type,transferee', 'nullable'],
             'email'=> ['string', 'email:rfc,dns', 'required'],
             'phone_no' => ['regex:/[0-9+()]*/'],
             'password'=> ['required', 'confirmed', 'string'],
             'grade_level_id'=> ['required_if:enrollee_type,old,transferee', 'integer', 'nullable'] ,
             'fathers_name'=> ['string', 'required'],
             'fathers_occupation'=> ['string'],
             'mothers_name'=> ['string', 'required'],
             'mothers_occupation'=> ['string'],
             'guardians_phone_no'=> ['regex:/[0-9]*/', 'required'],
             'guardians_email'=> ['email:dns,rfc'],
             'good_moral'=> ['required_if:enrollee_type,transferee', 'file', 'nullable'],
             'form_138'=> ['required_if:enrollee_type,transferee', 'file', 'nullable'],
             'birth_cert'=> ['required_if:enrollee_type,new,transferee', 'file'],

        ];
    }
}
