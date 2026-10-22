<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController as AdminFacilityController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\Admin\HousekeepingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// Public Guest Portal Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rooms Catalog & Availability Check
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{slug}', [RoomController::class, 'show'])->name('rooms.show');
Route::post('/api/rooms/check-availability', [RoomController::class, 'checkAvailability'])->name('api.rooms.availability');

// Facilities & Hotel Experiences
Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
Route::post('/facilities/book', [FacilityController::class, 'book'])->name('facilities.book');

// Online Reservation & Secure Payment Workflow
Route::get('/book', [BookingController::class, 'create'])->name('booking.create');
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
Route::get('/book/payment/{reference}', [BookingController::class, 'payment'])->name('booking.payment');
Route::post('/book/payment/{reference}', [BookingController::class, 'processPayment'])->name('booking.process-payment');
Route::get('/book/confirmation/{reference}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
Route::get('/book/receipt/{reference}', [BookingController::class, 'receipt'])->name('booking.receipt');
Route::get('/my-reservation', [BookingController::class, 'lookup'])->name('booking.lookup');

// Admin & Staff Authentication
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin & Front Desk Management
    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index']);

        // Reservations Management & Front Desk Check-in / Check-out
        Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/create', [AdminReservationController::class, 'create'])->name('reservations.create');
        Route::post('/reservations', [AdminReservationController::class, 'store'])->name('reservations.store');
        Route::get('/reservations/{reservation}', [AdminReservationController::class, 'show'])->name('reservations.show');
        Route::post('/reservations/{reservation}/check-in', [AdminReservationController::class, 'checkIn'])->name('reservations.check-in');
        Route::post('/reservations/{reservation}/check-out', [AdminReservationController::class, 'checkOut'])->name('reservations.check-out');
        Route::post('/reservations/{reservation}/assign-room', [AdminReservationController::class, 'assignRoom'])->name('reservations.assign-room');
        Route::post('/reservations/{reservation}/cancel', [AdminReservationController::class, 'cancel'])->name('reservations.cancel');

        // Rooms & Floor Management
        Route::get('/rooms', [AdminRoomController::class, 'index'])->name('rooms.index');
        Route::post('/rooms', [AdminRoomController::class, 'store'])->name('rooms.store');
        Route::post('/rooms/{room}/status', [AdminRoomController::class, 'updateStatus'])->name('rooms.status');
        Route::get('/room-types', [AdminRoomController::class, 'types'])->name('rooms.types');
        Route::post('/room-types/{roomType}', [AdminRoomController::class, 'updateType'])->name('rooms.types.update');

        // Housekeeping & Cleaning Board
        Route::get('/housekeeping', [HousekeepingController::class, 'index'])->name('housekeeping.index');
        Route::post('/housekeeping/task', [HousekeepingController::class, 'storeTask'])->name('housekeeping.store');
        Route::post('/housekeeping/task/{task}/status', [HousekeepingController::class, 'updateTaskStatus'])->name('housekeeping.task.status');
        Route::post('/housekeeping/room/{room}/mark-clean', [HousekeepingController::class, 'markClean'])->name('housekeeping.mark-clean');

        // Facility Operations & Daily Maintenance
        Route::get('/facilities', [AdminFacilityController::class, 'index'])->name('facilities.index');
        Route::post('/facilities/{facility}/status', [AdminFacilityController::class, 'updateStatus'])->name('facilities.status');
        Route::post('/facilities/booking', [AdminFacilityController::class, 'storeBooking'])->name('facilities.booking');

        // Guest CRM
        Route::get('/guests', [GuestController::class, 'index'])->name('guests.index');
        Route::get('/guests/{guest}', [GuestController::class, 'show'])->name('guests.show');
        Route::post('/guests/{guest}/toggle-vip', [GuestController::class, 'toggleVip'])->name('guests.toggle-vip');

        // Financial Ledger & Payments
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    });
});
