<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\DashboardController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('web')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

    Route::middleware('auth')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('students', StudentController::class);
        Route::get('students-sent-for-application', [StudentController::class, 'sentForApplication'])->name('students.sent-for-application');
        Route::get('students-application-completed', [StudentController::class, 'applicationCompleted'])->name('students.application-completed');
        Route::post('students/{student}/submit', [StudentController::class, 'submit'])->name('students.submit');
        Route::post('students/{student}/send-to-application', [StudentController::class, 'sendToApplication'])->name('students.send-to-application');
        Route::post('students/{student}/update-status', [StudentController::class, 'updateStatus'])->name('students.update-status');
        Route::get('students/{student}/download-document/{field}', [StudentController::class, 'downloadDocument'])->name('students.download-document');
        Route::get('students/{student}/download-additional-document/{index}', [StudentController::class, 'downloadAdditionalDocument'])->name('students.download-additional-document');
        Route::get('students/{student}/download-academic-document/{level}/{index}', [StudentController::class, 'downloadAcademicDocument'])->name('students.download-academic-document');
        Route::get('students/{student}/preview-document/{field}', [StudentController::class, 'previewDocument'])->name('students.preview-document');
        Route::get('students/{student}/preview-additional-document/{index}', [StudentController::class, 'previewAdditionalDocument'])->name('students.preview-additional-document');
        Route::get('students/{student}/preview-academic-document/{level}/{index}', [StudentController::class, 'previewAcademicDocument'])->name('students.preview-academic-document');
        Route::get('students/{student}/thumbnail-document/{field}', [StudentController::class, 'thumbnailDocument'])->name('students.thumbnail-document');
        Route::get('students/{student}/thumbnail-additional-document/{index}', [StudentController::class, 'thumbnailAdditionalDocument'])->name('students.thumbnail-additional-document');
        Route::get('students/{student}/thumbnail-academic-document/{level}/{index}', [StudentController::class, 'thumbnailAcademicDocument'])->name('students.thumbnail-academic-document');
        Route::delete('students/{student}/delete-document/{field}', [StudentController::class, 'deleteDocument'])->name('students.delete-document');
        Route::delete('students/{student}/delete-additional-document/{index}', [StudentController::class, 'deleteAdditionalDocument'])->name('students.delete-additional-document');
        Route::delete('students/{student}/delete-academic-document/{level}/{index}', [StudentController::class, 'deleteAcademicDocument'])->name('students.delete-academic-document');
        Route::post('students/{student}/replace-document/{field}', [StudentController::class, 'replaceDocument'])->name('students.replace-document');
        Route::get('students/{student}/thumbnail/{field}', [StudentController::class, 'getThumbnail'])->name('students.thumbnail');
        Route::get('students/{student}/download/{file}', [StudentController::class, 'download'])->name('students.download');
        
        Route::resource('users', UserController::class);
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
        Route::delete('/profile/picture', [UserController::class, 'removeProfilePicture'])->name('profile.remove-picture');
        
        // Notification routes
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
        Route::get('/notifications/count', [NotificationController::class, 'getUnreadCount'])->name('notifications.count');
        Route::get('/notifications/latest', [NotificationController::class, 'getLatest'])->name('notifications.latest');
        Route::get('/notifications/poll', [NotificationController::class, 'poll'])->name('notifications.poll');
        
        // Staff students route
        Route::get('/staff/{staffId}/students/{type}', [DashboardController::class, 'staffStudents'])->name('staff.students');
        
        // Storage link route (remove after running once)
        Route::get('/storage-link', function() {
            if (!file_exists(public_path('storage'))) {
                app('files')->link(
                    storage_path('app/public'), public_path('storage')
                );
                return 'Storage link created successfully!';
            }
            return 'Storage link already exists!';
        });
        
        // Fallback route to serve storage files
        Route::get('/storage/{path}', [FileController::class, 'serveFile'])->where('path', '.*')->name('storage.serve');
    });
});
