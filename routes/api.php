<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    
});

Route::get('/students', [StudentController::class, 'index']);
Route::get('/my_msg', function () {
    return 'hello';
});


Route::post('/post_test', function () {return response(["message" => "Foo"], 201);});
Route::apiResource('/test', StudentController::class);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('student/login', [StudentController::class, 'login']);
Route::get('/student/details', [StudentController::class, 'StudentInfo'])->middleware(['auth:sanctum', 'abilities:student']);

Route::post('/admin/login', [AdminController::class, 'login']);

Route::middleware(['auth:sanctum', 'abilities:admin,level-1'])->group(function(){
    Route::get('/admin/details', [AdminController::class, 'index']);
    Route::get('/admin/allStudents', [AdminController::class, 'allStudents']);
    Route::post('/admin/add_student', [StudentController::class, 'store']);
});
