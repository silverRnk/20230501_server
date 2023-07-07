<?php

use App\Http\Controllers\api\CredentialsController;
use Illuminate\Support\Facades\Route;

Route::prefix('credential')->group(function() {
    Route::post('/add', [CredentialsController::class,  'addStudentCredential']);
    Route::post('/update', [CredentialsController::class,  'addStudentCredential']);
    Route::get('/download/{id}/{credentialId}', [CredentialsController::class, 'download']);

});