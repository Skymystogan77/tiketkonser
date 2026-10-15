<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;

// Public UI
Route::get('/', [EventController::class, 'index'])->name('catalog');
Route::get('/checkout/{event}', [OrderController::class, 'showCheckout'])->name('checkout.show');
Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');

// Protected Admin Routes (Breeze Auth)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [OrderController::class, 'adminOrders'])->name('orders.index');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
    Route::get('/events', [EventController::class, 'adminIndex'])->name('events.index');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/dashboard', function () {
    return redirect()->route('admin.orders.index');
})->middleware(['auth'])->name('dashboard');
});

require __DIR__.'/auth.php';