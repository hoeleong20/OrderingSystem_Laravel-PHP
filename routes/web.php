<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'admin'])->group(function () {

});

route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

//route::get('post', [HomeController::class, 'post'])->middleware('auth','admin')->name('post');
use App\Http\Controllers\MenuController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::resource('menus', MenuController::class);
Route::get('/menu/adminMenu', [MenuController::class, 'adminIndex'])->name('menus.adminMenu');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/book', function () {
    return view('book');
})->name('book');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
