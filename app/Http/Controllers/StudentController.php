<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\AddStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use App\Http\Requests\StudentLoginRequest;
use Auth;

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
        // $student = Student::create([
        //     'std_Name' => ($data['std_first_name'].' '.$data['std_last_name']),
        //     'std_Gender' => $data['std_gender'],
        //     'std_date_of_birth' => $data['std_date_of_birth'],
        //     'std_parents_guardian' => $data['std_parents_guardian'],
        //     'std_Email' => $data['std_Email'],
        //     'std_Password' => bcrypt($data['std_Password']),
        //     'std_Photo' => $data['std_photo'],
        //     'std_cp_number' => $data['std_cp_number'],
        //     'tchr_Id' => 1,
        //     'class_Id' => $data['std_class'],
        //     'school_Id' => 1
        // ]);

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
