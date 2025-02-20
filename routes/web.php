<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return redirect()->route('tickets.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Ticket routes
    Route::resource('tickets', TicketController::class);
    Route::get('tickets/{ticket}/redeem', [TicketController::class, 'redeem'])
        ->name('tickets.redeem')
        ->middleware('web'); // Ensure session is available
    Route::get('tickets/{ticket}/qr-code', [TicketController::class, 'showQrCode'])->name('tickets.qrcode');
});

require __DIR__.'/auth.php';
