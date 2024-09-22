<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;




Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dasboard',[HomeController::class, 'adminIndex'])->name('admin.adminDashboard');
    Route::resource('menus', MenuController::class);
    Route::get('/admin/Menu', [MenuController::class, 'adminIndex'])->name('menus.adminMenu');
    Route::get('admin/UserList', [UserController::class, 'showUsers'])->name('admin.userList');
    Route::delete('admin/UserList', [UserController::class, 'deleteUser'])->name('admin.deleteUser');
});



route::get('/home', [HomeController::class, 'index'])->middleware('auth', 'verified')->name('home');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/about', function () {
    return view('menus.index');
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
    Route::post('/profile', [ProfileController::class, 'verifyBankAccount'])->name('profile.verifyBank');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
