<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/menus/menu', [MenuController::class, 'index'])->name('menu');

Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/book', function () {
    return view('book');
})->name('book');

