<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\MonitorSessionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SessionEnrollmentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUDs
    Route::resource('attendances', AttendanceController::class);
    Route::resource('monitors', MonitorController::class);
    Route::resource('monitor-sessions', MonitorSessionController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('posts', PostController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('users', UserController::class);

    Route::post('monitor-sessions/{monitorSession}/enrollments', [SessionEnrollmentController::class, 'store'])
        ->name('monitor-sessions.enrollments.store');
    Route::get('session-enrollments', [SessionEnrollmentController::class, 'index'])
        ->name('session-enrollments.index');
    Route::get('session-enrollments/{sessionEnrollment}', [SessionEnrollmentController::class, 'show'])
        ->name('session-enrollments.show');
    Route::delete('session-enrollments/{sessionEnrollment}', [SessionEnrollmentController::class, 'destroy'])
        ->name('session-enrollments.destroy');
});

require __DIR__.'/auth.php';