<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;

use Illuminate\Support\Facades\Route;


Route::prefix('forum')->name('forum.')->group(function() {
    Route::get('/', [TopicController::class, 'index'])->name('index');

    Route::get('/create', [TopicController::class, 'create'])->name('create');

    Route::post('/', [TopicController::class, 'store'])->name('store');

    Route::get('/topic/{topic}', [TopicController::class, 'show'])->name('topic');

    Route::get('/topic/{topic}/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/topic/{topicId}/post', [PostController::class, 'store'])->name('post.store');

    Route::get('/topic/{topic}/post/{post}', [PostController::class, 'show'])
        ->name('post.show')
        ->where(['post' => '[0-9a-f\-]+']);

    // Добавление ответа на пост
    Route::post('/topic/{topic}/post/{post}/reply', [ReplyController::class, 'store'])->name('reply.store');
});