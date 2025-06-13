<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PublicTaskController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('app');
});

// Autoryzacja
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Publiczny widok zadania
Route::get('public/tasks/{token}', [PublicTaskController::class, 'show'])->name('tasks.public');

// Zadania (tylko dla zalogowanych)
Route::middleware(['auth'])->group(function() {
    Route::resource('tasks', TaskController::class);
    Route::get('tasks/calendar', [TaskController::class, 'calendar'])->name('tasks.calendar');
    Route::post('tasks/{task}/public-link', [TaskController::class, 'generatePublicLink'])->name('tasks.generatePublicLink');
});