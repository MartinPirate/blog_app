<?php

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PostsController::class, 'welcome']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/dashboard', [PostsController::class, 'index'])->name('dashboard');
    Route::get('posts/create', [PostsController::class, 'create'])->name('post.create');
    Route::post('posts', [PostsController::class, 'store'])->name('post.save');
});

Route::get('posts/{post}', [PostsController::class, 'show'])->name('post.show');


