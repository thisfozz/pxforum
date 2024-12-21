<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;

Route::get('/', function () {
    return view('layouts.app');  // Главная страница с шаблоном app.blade.php
})->name('home');  // Имя маршрута для главной страницы

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/forums', function() { 
    return view('forums');  // Страница форума
})->name('forums');  // Имя маршрута для форума

Route::get('/popular', function() { 
    return view('popular');  // Страница популярного контента
})->name('popular');  // Имя маршрута для популярного контента

Route::get('/topics', function() { 
    return view('topics');  // Страница форума с всеми темами
})->name('topics');  // Имя маршрута для всех тем

Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

Route::get('/settings', [SettingsController::class, 'show'])->name('settings');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');