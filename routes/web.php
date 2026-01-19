<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('web')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    })->middleware('auth');

    Route::middleware('auth')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('students', StudentController::class);
        Route::get('students-sent-for-application', [StudentController::class, 'sentForApplication'])->name('students.sent-for-application');
        Route::get('students-application-completed', [StudentController::class, 'applicationCompleted'])->name('students.application-completed');
        Route::post('students/{student}/submit', [StudentController::class, 'submit'])->name('students.submit');
        Route::post('students/{student}/send-to-application', [StudentController::class, 'sendToApplication'])->name('students.send-to-application');
        Route::post('students/{student}/update-status', [StudentController::class, 'updateStatus'])->name('students.update-status');
        Route::get('students/{student}/download/{field}', [StudentController::class, 'downloadDocument'])->name('students.download-document');
        Route::get('students/{student}/thumbnail/{field}', [StudentController::class, 'getThumbnail'])->name('students.thumbnail');
        Route::get('students/{student}/download/{file}', [StudentController::class, 'download'])->name('students.download');
        
        Route::resource('users', UserController::class);
    });
});
