<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manager\PropertyController;
use App\Http\Controllers\Manager\BookingController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\ClientBookingController;
use App\Http\Controllers\Client\PropertyController as ClientPropertyController;

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    if (auth()->user()->role === 'manager') {
        return redirect()->route('manager.dashboard');
    }
    return redirect()->route('client.dashboard');
});

// Client Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/client/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    Route::post('/client/bookings', [ClientBookingController::class, 'store'])->name('client.bookings.store');
    Route::get('/client/properties/{property}', [ClientPropertyController::class, 'show'])->name('client.properties.show');
});

// Legacy dashboard route - redirects based on role
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'manager') {
        return redirect()->route('manager.dashboard');
    }
    return redirect()->route('client.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [PropertyController::class, 'index'])->name('dashboard');
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
    
    // Booking routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/bookings/pending', [BookingController::class, 'pending'])->name('bookings.pending');
});

require __DIR__.'/auth.php';
