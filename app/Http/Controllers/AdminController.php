<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
use Illuminate\Support\Facades\Log;
use Auth;

class AdminController extends Controller
{
    public function login(AdminLoginRequest $request){

        $input = $request->validated();
        Log::info($input);

        // $validation = \Validator::make($input, [
        //     'email' => 'required|email',
        //     'password' => 'required'
        // ]);


        // if ($validation->fails()){
        //     return response()->json(['error' => $validation->errors()], 422);
        // }

        if(!Auth::guard('admin')->attempt($input)){
            return response([
                'errors' => [
                    'password' => 'Provided password is invalid'
                ]
            ], 422);
        }

        /** @var Admin $user */
        $user = Auth::guard('admin')->user();
        $privilegeLevel = '';
        if($user['privilege'] == 1){
            $privilegeLevel = 'level-1';
        }elseif($user['privilege'] == 2){
            $privilegeLevel = 'level-2';
        }else{
            $privilegeLevel = 'level-3';
        }

        $token = $user->createToken('admin', ['admin', $privilegeLevel])->plainTextToken;
        return response(compact('user', 'token'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return response()->json(['data' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function allStudents(){
        return new StudentCollection(
            Student::query()->orderBy('std_ID', 'desc')->paginate(10))
            ;
    }
}
