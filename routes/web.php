<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartItemController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/menu', [MenuController::class, 'index'])->name('menus.index');
Route::resource('menus', MenuController::class);
Route::get('/menu/adminMenu', [MenuController::class, 'adminIndex'])->name('menus.adminMenu');

// Route::get('/order', action: [OrderController::class,'index'])->name('order.index');
// Route::get('/order/create', action: [OrderController::class,'create'])->name('order.create');
// Route::post('/order', action: [OrderController::class,'store'])->name('order.store');
// Route::get('/order/{id}', action: [OrderController::class,'show'])->name('order.show');
// Route::get('/order/{id}/edit', action: [OrderController::class,'edit'])->name('order.edit');
// Route::put('/order/{id}', action: [OrderController::class,'update'])->name('order.update');
// Route::delete('/order/{id}', action: [OrderController::class,'destroy'])->name('order.destroy');

// Route::get('/order/checkOut', [OrderController::class, 'checkOut'])->name('order.checkOut');
Route::get('/checkOut', [OrderController::class, 'checkOut'])->name('order.checkOut');
Route::post('/order/{id}/pay', [OrderController::class, 'pay'])->name('order.pay');



Route::resource('order',controller: OrderController::class);

Route::post('/api/send-cart-items-to-java', [CartItemController::class, 'sendCartItemsToJava']);



//  Route::post('/payment', action: [OrderController::class,'store'])->name('order.store');
//  Route::put('/order/{id}', action: [OrderController::class,'update'])->name('order.update');







Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/book', function () {
    return view('book');
})->name('book');
