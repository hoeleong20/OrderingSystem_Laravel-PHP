<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/menu', [MenuController::class, 'index'])->name('menus.index');

Route::get('/menu/create', [MenuController::class, 'create'])->name('menus.create');

Route::post('/menu', [MenuController::class, 'store'])->name('menus.store');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/book', function () {
    return view('book');
})->name('book');

