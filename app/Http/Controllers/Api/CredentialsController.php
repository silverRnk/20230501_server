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

        $fileNamePrefix = $data['credential_type'];

        $credentialCount = Credential::query()
            ->where('std_ID', $data[
                'student_id'
            ])->where('credential_type', $data['credential_type'])
            ->count();

        /** @var Credential $credential */
        $credential = Credential::query()
            ->where('std_ID', $data[
                'student_id'
            ])->where('credential_type', $data['credential_type'])->first();


        //Check if there is more than one 
        //then delete redundancy
        //to avoid redundancy
        if ($credentialCount > 1) {
            Credential::query()
                ->where('std_ID', $data['student_id'])
                ->where('credential_type', $data['credential_type'])
                ->whereNot('id', $credential->id)
                ->delete();
        }

        // dd($fileName);
        if (is_null($credential)) {
            $fileName = $fileNamePrefix.'_v1'.
            '.'.$file->extension();

            $filePath = Storage::putFileAs('public/student_credentials/' . $data['student_id'], $file, $fileName);
            Storage::setVisibility($filePath, 'public');
            $credential1 = Credential::create([
                "std_ID" => $data['student_id'],
                "credential_type" => $data['credential_type'],
                "file_name" => $fileName,
                "file_path" => $filePath
            ]);

            return response()->json([
                "data" => [
                    "message" => "credential has been added successfully"
                ]
            ], 201);
        } else {
            $versionNumber = 1;
            //Set version number
                
            if(preg_match('/._v[0-9]+[.]./', $credential->file_name)){
                $version = explode('.',explode('_',$credential->file_name)[3])[0];
                $versionNumber = (int) explode('v', $version)[1];

                //increase version number for update
                $versionNumber += 1;
            }

            
            if(Storage::getVisibility($credential->file_path) === 'private'){

            }

            $fileName = $fileNamePrefix.
            '_v'.(string)$versionNumber.
            '.'.$file->extension();
            
            if(Storage::exists($credential->file_path)){
                Storage::delete($credential->file_path);
            }

            
            $filePath = Storage::putFileAs('public/student_credentials/'.$data['student_id'], $file, $fileName,);
            $isSuccessful = $credential->update(
                [
                    'file_name' => $fileName,
                    'file_path' => $filePath
                ]
            );

            if ($isSuccessful == 1) {
                return response()->json([
                    "data" => [
                        "message" => "credential has been updated successfully"
                    ]
                ], 201);
            } else {
                return response()->json([
                    "data" => [
                        "message" => "something went wrong"
                    ]
                ], 401);
            }
        }

    }

    public function updateCredential(Request $request)
    {

    }

    /**
     * download credential file
     */
    public function download(string $id, string $credentialId)
    {

        /** @var Credential $credential */
        $credential = Credential::query()
            ->where('std_ID', $id)
            ->where('id', $credentialId)->first();

        return Storage::download($credential->file_path);
    }
}