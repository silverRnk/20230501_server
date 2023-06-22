<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUpdateStudentCredential;
use App\Models\Credential;
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

    public function addOrUpdateStudentCredential(AddUpdateStudentCredential $request)
    {
        $data = $request->validated();

        $file = $request->file('file');
        $newFileName = $data['student_id'].
        '_'.$data['credential_type'].
        '.'.$file->extension();

        $filePath = Storage::putFileAs('student_credentials', $file, $newFileName);
        
        //Store to DB
        $credential = Credential::create([
            'file_name' => $newFileName,
            'file_path' => $filePath,
            'std_ID' => $data['student_id']
        ]);

        return response()->json(['data' => $credential], 201);
    }

    public function downloadCredentials(String $id){

        $credential = Credential::query()->where('std_ID', $id)->get()[0];
        
        
        
    }
}
