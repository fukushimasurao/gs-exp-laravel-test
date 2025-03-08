<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/schedule-add', [ScheduleController::class, 'scheduleAdd'])->name('schedule-add');
    Route::post('/schedule-get', [ScheduleController::class, 'scheduleGet'])->name('schedule-get');
    Route::get('/schedule-list', [ScheduleController::class, 'scheduleList'])->name('schedule-list');
    Route::get('/schedules/{id}', [ScheduleController::class, 'show'])->name('schedules.show');
    Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::get('/schedules/{id}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');

    // ⭐️スケジュール詳細修正post(patch追加)
    Route::patch('/schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update');
});

require __DIR__.'/auth.php';
