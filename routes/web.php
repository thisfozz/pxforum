<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;

Route::get('/', function () {
    return view('home.index');
})->name('home');

// Гостевой роут. Доступен только незалогиненным пользователей
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Защищенный роут. Доступен только залогиненным пользователям
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings');
});

Route::prefix('forum')->name('forum.')->group(function() {
    // Просмотр всех топиков
    Route::get('/', [TopicController::class, 'index'])->name('index');

    // Страница создания нового топика
    Route::get('/create', [TopicController::class, 'create'])->name('create');

    // Сохранение нового топика
    Route::post('/', [TopicController::class, 'store'])->name('store');

    // Просмотр топика (посты внутри топика)
    Route::get('/topic/{topic}', [TopicController::class, 'show'])->name('topic');

    // Просмотр поста с ответами
    Route::get('/topic/{topic}/post/{post}', [PostController::class, 'showPost'])->name('post');

    // Страница создания нового поста
    Route::get('/topic/{topic}/post/create', [PostController::class, 'create'])->name('post.create');

    // Сохранение нового поста
    Route::post('/topic/{topic}/post', [PostController::class, 'store'])->name('post.store');

    // Добавление ответа на пост
    Route::post('/topic/{topic}/post/{post}/reply', [ReplyController::class, 'store'])->name('reply.store');
});