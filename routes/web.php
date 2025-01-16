<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\Auth\LoginController;

Auth::routes();

    Route::get('/', function () {
        return redirect('/login');
    });
    // Rutas para USUARIOS FINALES
    Route::middleware(['auth', 'user.final'])->group(function () {
        Route::get('/lista-articulos', [ArticleController::class, 'getArticulos'])->name('public.articles.index');
        Route::get('/articulo/{id}', [ArticleController::class, 'showArticulos'])->name('articles.show');
    });
    // Rutas para ADMINISTRADORES
    Route::middleware(['auth'])->group(function () {
        //Rutas de usuario final
        //rutas de admin
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        //Rutas para el manejo del CRUD de articulos
        Route::get('/articulos', [ArticleController::class, 'index'])->name('articles.index');
        Route::get('/articulos/create', [ArticleController::class, 'create'])->name('articles.create');
        Route::post('/articulos', [ArticleController::class, 'store'])->name('articles.store');
        Route::get('/articulos/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
        Route::put('/articulo/{article}', [ArticleController::class, 'update'])->name('articles.update');
        Route::delete('/articulos/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
        // CRUD categorías
        Route::get('/categorias', [CategoryController::class, 'index'])->name('categorias.index');
        Route::get('/categorias/create', [CategoryController::class, 'create'])->name('categorias.create');
        Route::post('/categorias', [CategoryController::class, 'store'])->name('categorias.store');
        Route::get('/categorias/{categoria}/edit', [CategoryController::class, 'edit'])->name('categorias.edit');
        Route::put('/categoria/{category}', [CategoryController::class, 'update'])->name('categorias.update');
        Route::delete('/categorias/{category}', [CategoryController::class, 'destroy'])->name('categorias.destroy');
        // CRUD de usuarios
        Route::get('/usuarios/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
        Route::get('/usuarios/{iduser}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/usuario/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
