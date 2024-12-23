<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;

Route::get('/', function () {
    return view('layouts.app');
})->name('home');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/forums', function() { 
    return view('forums');
})->name('forums');

Route::get('/popular', function() { 
    return view('popular');
})->name('popular');

Route::get('/topics', function() { 
    return view('topics');
})->name('topics');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

Route::get('/settings', [SettingsController::class, 'show'])->name('settings');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');