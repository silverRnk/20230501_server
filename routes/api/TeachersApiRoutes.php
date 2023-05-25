<?php

use App\Http\Controllers\Api\TeacherController;
use Illuminate\Support\Facades\Route;

Route::prefix('teachers')->group(function () {
    Route::post('/add', [TeacherController::class, 'add']);

    Route::get('/all', [TeacherController::class, 'all']);

    Route::get('/teacher/{id}', [TeacherController::class, 'view']);
});