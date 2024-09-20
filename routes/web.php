<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/book', function () {
    return view('book');
})->name('book');

Route::get('/cartPage', function () {
    return view('cartPage');
})->name('cartPage');

Route::get('/orderSummaryPage', function () {
    return view('orderSummaryPage');
})->name('orderSummaryPage');