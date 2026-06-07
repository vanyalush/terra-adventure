<?php

use App\Http\Controllers\CabinetController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\HikeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

// Главная
Route::get('/', [PageController::class, 'home'])->name('home');
// Breeze uses 'dashboard' route name in some controllers
Route::get('/dashboard', fn () => redirect()->route('home'))->name('dashboard');

// Статичные страницы
Route::get('/payment', fn () => view('pages.payment'))->name('payment');
Route::get('/location', fn () => view('pages.location'))->name('location');

// Каталог
Route::get('/catalog', [HikeController::class, 'index'])->name('catalog');
Route::get('/hikes/{hike}', [HikeController::class, 'show'])->name('hikes.show');

// Запись — только для авторизованных
Route::middleware('auth')->group(function () {
    Route::get('/booking/{hike}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/{hike}', [BookingController::class, 'store'])->name('booking.store');

    // Личный кабинет
    Route::get('/cabinet', [CabinetController::class, 'index'])->name('cabinet.index');
    Route::patch('/cabinet/bookings/{booking}/cancel', [CabinetController::class, 'cancel'])->name('cabinet.cancel');

    // Профиль
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Админ
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/hikes', [AdminController::class, 'hikes'])->name('admin.hikes');
    Route::post('/hikes', [AdminController::class, 'storeHike'])->name('admin.hikes.store');
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
    Route::post('/bookings/{booking}/confirm', [AdminController::class, 'confirmBooking'])->name('admin.booking.confirm');
    Route::post('/bookings/{booking}/cancel', [AdminController::class, 'cancelBooking'])->name('admin.booking.cancel');
    Route::post('/reviews/{review}/approve', [AdminController::class, 'approveReview'])->name('admin.review.approve');
    Route::post('/reviews/{review}/reject', [AdminController::class, 'rejectReview'])->name('admin.review.reject');
});

require __DIR__.'/auth.php';
