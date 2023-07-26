<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollmentRequest;
use App\Models\Enrollee;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EnrollmentController extends Controller
{
    public function enroll(EnrollmentRequest $request){

        $data = $request->validated();

        $enrollee = Enrollee::create([
            'name' => $data['first_name'].' '.$data['last_name'],
            'date_of_birth'=> $data['date_of_birth'],
             'gender'=> $data['gender'],
             'address'=> $data['address'],
             'place_of_birth'=> $data['place_of_birth'],
             'prev_school'=> $data['prev_school'],
             'phone_no' => $data['phone_no'],
             'email'=> $data['email'],
             'password'=> $data['password'],
             'enrollee_type' => $data['enrollee_type'],
             'grade_level_id'=> $data['grade_level_id'],
             'fathers_name'=> $data['fathers_name'],
             'fathers_occupation'=> $data['fathers_occupation'],
             'mothers_name'=> $data['mothers_name'],
             'mothers_occupation'=> $data['mothers_occupation'],
             'guardians_phone_no'=> $data['guardians_phone_no'],
             'guardians_email'=> $data['guardians_email'],
             'validated' => false,
        ]);

        /**
         * @var UploadedFile|array|null $goodMoral
         */
        $goodMoral = $request->file('good_moral');
        if($goodMoral !== null){
            $goodMoralName = $enrollee->id.'_good_moral.'.$goodMoral->extension();
        
            $goodMoralPath = Storage::putFileAs('public/enrollee_credentials/'.$enrollee->id, $goodMoral, $goodMoralName);
            //Return error response if false
            if(!$goodMoralPath){
                return response()->json(['error' => 'File cannot be stored'], 401);
            }
    
            Storage::setVisibility($goodMoralPath, 'public');

            $enrollee->good_moral = $goodMoralPath;
        }

        /**
         * @var UploadedFile|array|null $form138
         */
        $form138 = $request->file('form_138');
        if($form138 !== null){
            $form138Name = $enrollee->id.'_form_138.'.$form138->extension();
        
            $form138Path = Storage::putFileAs('public/enrollee_credentials/'.$enrollee->id, $form138, $form138Name);
            //Return error response if false
            if(!$form138Path){
                return response()->json(['error' => 'File cannot be stored'], 401);
            }
    
            Storage::setVisibility($form138Path, 'public');
            $enrollee->form_138 = $form138Path;
        }

        /**
         * @var UploadedFile|array|null $birthCert
         */
        $birthCert = $request->file('birth_cert');
        if($birthCert !== null){
            $birthCertName = $enrollee->id.'_birth_cert.'.$birthCert->extension();
        
            $birthCertPath = Storage::putFileAs(
                'public/enrollee_credentials/'.$enrollee->id,
                $birthCert,
                $birthCertName);
            //Return error response if false
            if(!$birthCertPath){
                return response()->json(['error' => 'File cannot be stored'], 401);
            }
    
            Storage::setVisibility($birthCertPath, 'public');
            $enrollee->birth_cert = $birthCertPath;
        }

        $enrollee->save();

        return response()->json(['message' => 'Registration is Successful', 'queueID' => $enrollee->id], 201);
    }

    public function verifiedEnrollee(String $id){

        return response()->json(['message' => 'Enrollment successfully verified'], 201);
    }

    public function enrollmentList(){
        
    }
}
