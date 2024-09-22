<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/menu', [MenuController::class, 'index'])->name('menus.index');
Route::resource('menus', MenuController::class);
Route::get('/menu/adminMenu', [MenuController::class, 'adminIndex'])->name('menus.adminMenu');
Route::get('/menu/{menu_code}', [MenuController::class, 'show'])->name('menus.show');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/book', function () {
    return view('book');
})->name('book');

Route::resource('reservations', ReservationController::class);
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations/{id}/summary', [ReservationController::class, 'summary'])->name('reservations.summary');