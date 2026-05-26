<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\MonitorDashboardController;
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

    // Rutas accesibles para TODOS los roles
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta de inscripción accesible para TODOS los roles autenticados
    Route::post('monitor-sessions/{monitorSession}/enrollments', [SessionEnrollmentController::class, 'store'])
        ->name('monitor-sessions.enrollments.store');

    // Rutas SOLO para MONITOR (role_id == 2)
    Route::middleware('role:2')->group(function () {
        Route::get('/monitor/dashboard', [MonitorDashboardController::class, 'index'])->name('monitor.dashboard');
    });

    // Rutas SOLO para ADMIN (role_id == 1)
    Route::middleware('role:1')->group(function () {
        Route::resource('monitors', MonitorController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('subjects', SubjectController::class);
    });

    // Rutas para ADMIN y MONITOR (role_id == 1 o 2)
    Route::middleware('role:1,2')->group(function () {
        Route::resource('schedules', ScheduleController::class);
        Route::resource('attendances', AttendanceController::class);
        Route::resource('monitor-sessions', MonitorSessionController::class);
        Route::post('monitor-sessions/{monitorSession}/materials', [MonitorSessionController::class, 'storeMaterial'])
            ->name('monitor-sessions.materials.store');
        Route::delete('monitor-sessions/{monitorSession}/materials/{sessionMaterial}', [MonitorSessionController::class, 'destroyMaterial'])
            ->name('monitor-sessions.materials.destroy');
        Route::resource('comments', CommentController::class);
        Route::resource('posts', PostController::class);
    });

    // Rutas SOLO para ESTUDIANTES (role_id == 3)
    Route::middleware('role:3')->group(function () {
        Route::get('session-enrollments', [SessionEnrollmentController::class, 'index'])
            ->name('session-enrollments.index');
        Route::get('session-enrollments/{sessionEnrollment}', [SessionEnrollmentController::class, 'show'])
            ->name('session-enrollments.show');
        Route::delete('session-enrollments/{sessionEnrollment}', [SessionEnrollmentController::class, 'destroy'])
            ->name('session-enrollments.destroy');
    });
});

require __DIR__.'/auth.php';