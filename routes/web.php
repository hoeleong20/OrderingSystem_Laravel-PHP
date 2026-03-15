<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DiscountController;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

// Admin routes
Route::middleware(['auth', 'admin', 'verified'])->group(function () {
    Route::get('/admin/dashboard', [HomeController::class, 'adminIndex'])->name('admin.adminDashboard');
    Route::resource('menus', MenuController::class);
    Route::get('/admin/menu', [MenuController::class, 'adminIndex'])->name('menus.adminMenu');
    Route::get('/admin/user-list', [UserController::class, 'showUsers'])->name('admin.userList');
    Route::delete('/admin/user-list', [UserController::class, 'deleteUser'])->name('admin.deleteUser');

    Route::get('/admin/discount', [DiscountController::class, 'index'])->name('admin.discount');
    Route::get('/admin/discount/create', [DiscountController::class, 'create'])->name('discount.create');
    Route::post('/admin/discount', [DiscountController::class, 'store'])->name('discount.store');
    Route::get('/admin/discount/{id}/view', [DiscountController::class, 'view'])->name('discount.view');
    Route::get('/admin/discount/{id}/edit', [DiscountController::class, 'edit'])->name('discount.edit');
    Route::patch('/admin/discount/{id}', [DiscountController::class, 'update'])->name('discount.update');
    Route::delete('/admin/discount/{id}', [DiscountController::class, 'destroy'])->name('discount.destroy');
    Route::patch('/admin/discount/{id}/activate', [DiscountController::class, 'activate'])->name('discount.activate');
});

// Authenticated user routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile', [ProfileController::class, 'verifyBankAccount'])->name('profile.verifyBank');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/menu', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/menu/{menu_code}', [MenuController::class, 'show'])->name('menus.show');

    Route::get('/checkout', [OrderController::class, 'checkOut'])->name('order.checkOut');
    Route::post('/order/{id}/pay', [OrderController::class, 'pay'])->name('order.pay');
    Route::resource('order', OrderController::class);

    Route::post('/menus/send-sold-out', [MenuController::class, 'sendSoldOutMenus'])->name('menus.sendSoldOutMenus');
    Route::get('/menus/activate', [MenuController::class, 'activatePage'])->name('menus.activatePage');
    Route::post('/menus/activate', [MenuController::class, 'activateAllMenus'])->name('menus.activateAll');

    Route::post('/discount/check', [DiscountController::class, 'check'])->name('discount.check');
    Route::post('/discount/calculate', [DiscountController::class, 'calculate'])->name('discount.calculate');

    // Reservation routes
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/dish', [ReservationController::class, 'createDishReservation'])->name('reservations.dish');
    Route::get('/reservations/table_with_dish', [ReservationController::class, 'createTableWithDishReservation'])->name('reservations.table_with_dish');
    Route::get('/reservations/event', [ReservationController::class, 'createEventReservation'])->name('reservations.event');
    Route::get('/reservations/{id}/summary', [ReservationController::class, 'summary'])->name('reservations.summary');
    Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::get('/reservations/export/xml', [ReservationController::class, 'exportReservationsToXML'])->name('reservations.export.xml');
    Route::get('/reservations/transform/xslt', [ReservationController::class, 'transformXMLWithXSLT'])->name('reservations.transform.xslt');
    Route::get('/reservations/search/{customerName}', [ReservationController::class, 'searchReservationByXPath'])->name('reservations.search.xpath');

    Route::get('/restaurant/rating', function () {
        $response = Http::get(config('services.python_api.url') . '/api/restaurant/rating');

        if ($response->successful()) {
            $rating = $response->json()['average_rating'];
            return view('ratings', ['rating' => $rating]);
        }

        return back()->with('error', 'Error fetching rating.');
    });

    Route::get('/about', function () {
        return view('menus.index');
    })->name('about');
});

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__ . '/auth.php';
