<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('forum')->name('forum.')->group(function() {
    // Просмотр всех топиков (главная страница форума)
    Route::get('/', [TopicController::class, 'index'])->name('index');

    // Страница создания нового топика `/forum/create`
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

require __DIR__.'/auth.php';