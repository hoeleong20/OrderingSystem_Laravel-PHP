<?php


use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\OrderController;


// Author: Ting Jian Hao
Route::middleware(['auth', 'admin', 'verified'])->group(function () {
    Route::get('/admin/dasboard', [HomeController::class, 'adminIndex'])->name('admin.adminDashboard');
    Route::resource('menus', MenuController::class);
    Route::get('/admin/Menu', [MenuController::class, 'adminIndex'])->name('menus.adminMenu');
    Route::get('admin/UserList', [UserController::class, 'showUsers'])->name('admin.userList');
    Route::delete('admin/UserList', [UserController::class, 'deleteUser'])->name('admin.deleteUser');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile', [ProfileController::class, 'verifyBankAccount'])->name('profile.verifyBank');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/menu', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/checkOut', [OrderController::class, 'checkOut'])->name('order.checkOut');
    Route::post('/order/{id}/pay', [OrderController::class, 'pay'])->name('order.pay');
    Route::resource('order', controller: OrderController::class);
    Route::get('/menu/{menu_code}', [MenuController::class, 'show'])->name('menus.show');
    Route::post('/menus/send-sold-out', [MenuController::class, 'sendSoldOutMenus'])->name('menus.sendSoldOutMenus');
    Route::get('/menus/activate', [MenuController::class, 'activatePage'])->name('menus.activatePage');
    Route::post('/menus/activate', [MenuController::class, 'activateMenus'])->name('menus.activate');
    
    
    
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
    Route::get('/reservations/export/xml', [ReservationController::class, 'exportReservationsToXML'])->name('reservations.export.xml');
    Route::get('/reservations/transform/xslt', [ReservationController::class, 'transformXMLWithXSLT'])->name('reservations.transform.xslt');
    Route::get('/reservations/search/{customerName}', [ReservationController::class, 'searchReservationByXPath'])->name('reservations.search.xpath');


    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/menu', [MenuController::class, 'index'])->name('menus.index');



    Route::get('/about', function () {
        return view('menus.index');
    })->name('about');
});


require __DIR__ . '/auth.php';

