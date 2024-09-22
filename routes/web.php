<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/menu', [MenuController::class, 'index'])->name('menus.index');
Route::resource('menus', MenuController::class);
Route::get('/menu/adminMenu', [MenuController::class, 'adminIndex'])->name('menus.adminMenu');
Route::get('/menu/{menu_code}', [MenuController::class, 'show'])->name('menus.show');
Route::post('/menus/send-sold-out', [MenuController::class, 'sendSoldOutMenus'])->name('menus.sendSoldOutMenus');
Route::get('/menus/activate', [MenuController::class, 'activatePage'])->name('menus.activatePage');
Route::post('/menus/activate', [MenuController::class, 'activateMenus'])->name('menus.activate');


Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/book', function () {
    return view('book');
})->name('book');

