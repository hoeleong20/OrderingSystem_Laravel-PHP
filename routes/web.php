<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Http;

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




// Author Khor Zhi Ying
Route::get('/book', function () {
    return view('book');
})->name('book');

// Resource route for reservation CRUD
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations/{id}/summary', [ReservationController::class, 'summary'])->name('reservations.summary');
Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

// Keep this for table_with_dish and event
Route::get('/reservations/table_with_dish', [ReservationController::class, 'createTableWithDishReservation'])->name('reservations.table_with_dish');
Route::get('/reservations/event', [ReservationController::class, 'createEventReservation'])->name('reservations.event');

// Route for accessing the dish reservation form
Route::get('/reservations/dish', [ReservationController::class, 'createDishReservation'])->name('reservations.dish');

Route::get('/restaurant/rating', function () {
    // Call the Python API
    $response = Http::get('http://localhost:5000/api/restaurant/rating');

    // Check if the response is successful
    if ($response->successful()) {
        // Retrieve the average rating from the JSON response
        $rating = $response->json()['average_rating'];

        // Pass the rating to the Blade view
        return view('ratings', ['rating' => $rating]);
    } else {
        return "Error fetching rating.";
    }
});
