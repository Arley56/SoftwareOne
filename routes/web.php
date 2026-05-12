<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitorSessionController;
use App\Http\Controllers\RoleController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Rutas usuarios
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// Rutas monitors
Route::post('/monitors', [MonitorController::class, 'store'])->name('monitors.store');
Route::get('/monitors', [MonitorController::class, 'index'])->name('monitors.index');
Route::get('/monitors/create', [MonitorController::class, 'create'])->name('monitors.create');
Route::get('/monitors/{id}', [MonitorController::class, 'show'])->name('monitors.show');
Route::get('/monitors/{id}/edit', [MonitorController::class, 'edit'])->name('monitors.edit');
Route::put('/monitors/{id}', [MonitorController::class, 'update'])->name('monitors.update');
Route::delete('/monitors/{id}', [MonitorController::class, 'destroy'])->name('monitors.destroy');

// Rutas subjects
Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
Route::get('/subjects/{id}', [SubjectController::class, 'show'])->name('subjects.show');
Route::get('/subjects/{id}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
Route::put('/subjects/{id}', [SubjectController::class, 'update'])->name('subjects.update');
Route::delete('/subjects/{id}', [SubjectController::class, 'destroy'])->name('subjects.destroy');

// Rutas schedules
Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
Route::get('/schedules/{id}', [ScheduleController::class, 'show'])->name('schedules.show');
Route::get('/schedules/{id}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
Route::put('/schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update');
Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

// Rutas attendances
Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
Route::get('/attendances/{id}', [AttendanceController::class, 'show'])->name('attendances.show');
Route::get('/attendances/{id}/edit', [AttendanceController::class, 'edit'])->name('attendances.edit');  
Route::put('/attendances/{id}', [AttendanceController::class, 'update'])->name('attendances.update');
Route::delete('/attendances/{id}', [AttendanceController::class, 'destroy'])->name('attendances.destroy');

//Rutas monitor sessions
Route::post('/monitor_sessions', [MonitorSessionController::class, 'store'])->name('monitor_sessions.store');
Route::get('/monitor_sessions', [MonitorSessionController::class, 'index'])->name('monitor_sessions.index');
Route::get('/monitor_sessions/create', [MonitorSessionController::class, 'create'])->name('monitor_sessions.create');
Route::get('/monitor_sessions/{id}', [MonitorSessionController::class, 'show'])->name('monitor_sessions.show');
Route::get('/monitor_sessions/{id}/edit', [MonitorSessionController::class, 'edit'])->name('monitor_sessions.edit');
Route::put('/monitor_sessions/{id}', [MonitorSessionController::class, 'update'])->name('monitor_sessions.update');
Route::delete('/monitor_sessions/{id}', [MonitorSessionController::class, 'destroy'])->name('monitor_sessions.destroy');   


// Rutas roles
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');