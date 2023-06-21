<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\GradeAndSectionController;
use App\Http\Controllers\Api\StudentProfileController;
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


Route::post('student/login', [StudentController::class, 'login']);
Route::get('/student/details', [StudentController::class, 'StudentInfo'])->middleware(['auth:sanctum', 'abilities:student']);

Route::post('/admin/login', [AdminController::class, 'login']);

Route::prefix('v1')->group(function(){
    //Route for Login
    Route::post('/admin/login', [AdminController::class, 'login']);

    //Route exclusive for admin user only
    Route::middleware(['auth:sanctum', 'abilities:admin,level-1'])
    ->prefix('admin')
    ->group(function(){
        Route::get('/details', [AdminController::class, 'index']);
        Route::get('/allStudents', [AdminController::class, 'allStudents']);
        Route::post('/add_student', [StudentController::class, 'store']);
        Route::get('/student/{id}', [StudentProfileController::class, 'profile']);
        Route::get('/gradesAndSections', [GradeAndSectionController::class, 'gradesAndSections']);
        require_once __DIR__.'/api/TeachersApiRoutes.php';
    });
});

Route::middleware(['auth:sanctum', 'abilities:admin,level-1'])
    ->prefix('admin')
    ->group(function(){
        Route::get('/details', [AdminController::class, 'index']);
        Route::get('/allStudents', [AdminController::class, 'allStudents']);
        Route::post('/add_student', [StudentController::class, 'store']);
        Route::get('/student/{id}', [StudentProfileController::class, 'profile']);
        Route::get('/gradesAndSections', [GradeAndSectionController::class, 'gradesAndSections']);
        require_once __DIR__.'/api/TeachersApiRoutes.php';
    });





