<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('main');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resources([
        'task_status' => TaskStatusController::class,
    ]);
});
Route::get('/task_status', [TaskStatusController::class, 'index'])->name('task_status.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resources([
        'tasks' => TaskController::class,
    ]);
});
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

require __DIR__ . '/auth.php';
