<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUpdateStudentCredential;
use App\Models\Credential;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CredentialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function addStudentCredential(AddUpdateStudentCredential $request)
    {
        $data = $request->validated();

        $file = $request->file('file');
        $newFileName = $data['student_id'].
        '_'.$data['credential_type'].
        '.'.$file->extension();

        $filePath = Storage::putFileAs('student_credentials', $file, $newFileName);
        

        /** @var Student $student */
        $student = Student::query()
        ->where('std_ID', $data['student_id'])
        ->first();

        $credential = $student->credentials()->updateOrCreate(
            [
                'std_ID' => $data['student_id'],
                'credential_type' => $data['credential_type'],
                'file_name' => $newFileName,
                'file_path' => $filePath
            ]
            );

        // //Store to DB
        // $credential = Credential::create([
        //     'file_name' => $newFileName,
        //     'file_path' => $filePath,
        //     'std_ID' => $data['student_id']
        // ]);

        return response()->json(['data' => $credential], 201);
    }

    public function updateCredential(Request $request){

    }

    public function downloadCredentialFile(String $id, String $credentialId){

        /** @var Credential $credential */
        $credential = Credential::query()
        ->where('std_ID', $id)
        ->where('id', $credentialId)->first();
        
        return Storage::download($credential->file_path);
    }
}
