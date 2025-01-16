<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;


Auth::routes();
Route::get('/articulos', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articulos/{id}', [ArticleController::class, 'show'])->name('articles.show');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::get('/articulos', [ArticleController::class, 'index']);
// Route::get('/articulos/{id}', [ArticleController::class, 'show']);