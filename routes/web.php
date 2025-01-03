<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/home', [AuthController::class, 'home'])->middleware('auth')->name('home');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//post
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
// Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
// Route::post('/posts/{postId}/like', [PostController::class, 'like'])->name('posts.like');

Route::post('/posts/{postId}', [PostController::class, 'like'])->name('like');


Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/reply', [CommentController::class, 'reply'])->name('comments.reply');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
