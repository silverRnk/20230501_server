<?php

namespace App\Http\Controllers;

use App\Models\ParentInfo;
use App\Models\Student;
use App\Http\Requests\AddStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use App\Http\Requests\StudentLoginRequest;
use Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Student::query()->orderBy('std_ID', 'desc')->paginate(10)->toJson(JSON_PRETTY_PRINT);
        // return response(['message' => 'hello'], 200);
        // return StudentResource::collection(Student::all());
        return StudentResource::collection(
            Student::query()->orderBy('std_ID', 'desc')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddStudentRequest $request)
    {
        $data = $request->validated();

        /** @var \App\Models\Student $student */
        $student = Student::create([
            'std_name' => $data['std_first_name'].' '.$data['std_last_name'],
            'std_gender' => $data['std_gender'],
            'std_date_of_birth' => $data['std_date_of_birth'],
            'std_religion' => $data['std_religion'],
            // 'std_phone' => $data['std_phone'],
            'std_email' => $data['std_email'],
            'password' => bcrypt($data['std_password']),
            'std_photo' => null,
            'std_status' => 'new',
            'tchr_Id' => 1, // remove from table add to sections table
            'grade_level_id' => 'nrs',
            'section_id'=> '1',
            'school_Id' => 1
        ]);

        $parentInfo = ParentInfo::create([
            'fathers_name' => $data['fathers_name'],
            'mothers_name' => $data['mothers_name'],
            'fathers_occupation' => $data['fathers_occupation'],
            'parents_phone_no' => $data['parents_phone'],
            'parents_religion' => $data['parents_religion'],
            'parents_email' => $data['parents_email'],
            'student_id' => $student->std_ID
        ]);

        $file = $data['std_photo'];
        // dd($file);
        $file_name = $student->std_ID.'.'.$file->extension();
        $file_path = Storage::putFileAs(
            'student_profile_imgs', $file, $file_name);
        $student->std_photo = $file_path;
        $student->save();
        
        return response(['message' => ['student is added successfully']], 201) ;
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $data = $request->validated();
        if (isset($data['std_Password'])){
            $data['std_Password'] = bcrypt($data['$std_Password']);
        }

        $student->update($data);

        return response(['message' => ['Successfully Updated']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        return response('', 204);
    }

    public function login(Request $request){

        $input = $request->all();

        $validation = \Validator::make($input, [
            'std_email' => ['required', 'email'],
            'std_password' => 'required'
        ]);


        if ($validation->fails()){
            return response()->json(['error' => $validation->errors()], 422);
        }

        if(!Auth::guard('student')->attempt([
            'std_email' => $input['std_email'],
            'password' => $input['std_password']
        ])){
            return response([
                'message' => 'Provided email address or password is incorrect'
            ], 422);
        }

        /** @var Student $user */
        $user = Auth::guard('student')->user();
        $token = $user->createToken('students', ['student'])->plainTextToken;
        return response(compact('user', 'token'));

    }

    

    public function StudentInfo(){
        $user = Auth::user();
        return response()->json(['data' => $user]);
    }

    public function getStudentInfo($std_id){

        $student = Student::where('std_ID', $std_id)->get();


        return new StudentResource($student);
    }
}
