<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddTeacherRequest;
use App\Http\Resources\TeachersCollection;
use App\Http\Resources\ViewTeacherCollection;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function all()
    {

        return new TeachersCollection(
            Teacher::query()
                ->orderBy('uuid', 'desc')
                ->paginate(10)
        );

    }

    public function add(AddTeacherRequest $request)
    {

        $data = $request->validated();

        //Create Row
        $teacher = Teacher::create(
            [
                'name' => $data['first_name'] . ' ' . $data['last_name'],
                'gender' => $data['gender'],
                'date_of_birth' => $data['date_of_birth'],
                'address' => $data['addr_line1'],
                'religion' => $data['religion'],
                'advisory_class' => $data['advisory_class'],
                'email' => $data['email'],
                'phone_no' => $data['phone_no'],
                'password' => bcrypt($data['password']),
                'admission_date' => $data['admission_date']
            ]
        );

        if (!empty($data['profile_img'])) {
            //Get Image from request
            $file = $data['profile_img'];

            //Rename Image
            $file_name = $teacher->uuid . '.' . $file->extension();

            //Save Image to storage then get the file path
            $img_path = Storage::putFileAs('teacher_profile_imgs', $file, $file_name);
            //Add the file path to the current teacher
            $teacher->profile_img = $img_path;
        }

        $teacher->save();
        //return successful
        return response(['message' => 'New Teacher is added successfully'], 201);

    }

    public function view(string $id)
    {

        return new ViewTeacherCollection(
            Teacher::where('uuid', $id)->get()
        );
    }
}