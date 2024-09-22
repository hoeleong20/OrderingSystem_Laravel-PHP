<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartItemController;




Route::middleware(['auth', 'admin', 'verified'])->group(function () {
    Route::get('/admin/dasboard',[HomeController::class, 'adminIndex'])->name('admin.adminDashboard');
    Route::resource('menus', MenuController::class);
    Route::get('/admin/Menu', [MenuController::class, 'adminIndex'])->name('menus.adminMenu');
    Route::get('admin/UserList', [UserController::class, 'showUsers'])->name('admin.userList');
    Route::delete('admin/UserList', [UserController::class, 'deleteUser'])->name('admin.deleteUser');
});


Route::middleware(['auth','verified'])->group(function(){
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile', [ProfileController::class, 'verifyBankAccount'])->name('profile.verifyBank');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/menu', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/checkOut', [OrderController::class, 'checkOut'])->name('order.checkOut');
    Route::post('/order/{id}/pay', [OrderController::class, 'pay'])->name('order.pay');
    Route::resource('order',controller: OrderController::class);
    Route::post('/api/send-cart-items-to-java', [CartItemController::class, 'sendCartItemsToJava']);
});



Route::get('/', function () {
    return view('welcome');
})->name('welcome');


// Route::get('/order', action: [OrderController::class,'index'])->name('order.index');
// Route::get('/order/create', action: [OrderController::class,'create'])->name('order.create');
// Route::post('/order', action: [OrderController::class,'store'])->name('order.store');
// Route::get('/order/{id}', action: [OrderController::class,'show'])->name('order.show');
// Route::get('/order/{id}/edit', action: [OrderController::class,'edit'])->name('order.edit');
// Route::put('/order/{id}', action: [OrderController::class,'update'])->name('order.update');
// Route::delete('/order/{id}', action: [OrderController::class,'destroy'])->name('order.destroy');

// Route::get('/order/checkOut', [OrderController::class, 'checkOut'])->name('order.checkOut');




//  Route::post('/payment', action: [OrderController::class,'store'])->name('order.store');
//  Route::put('/order/{id}', action: [OrderController::class,'update'])->name('order.update');




Route::get('/about', function () {
    return view('menus.index');
})->name('about');

Route::get('/book', function () {
    return view('book');
})->name('book');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/auth.php';
