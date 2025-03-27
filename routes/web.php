<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('tickets', TicketController::class);
});

Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

Route::post('tickets/{ticket}/message', [MessageController::class, 'store'])->name('tickets.message.store');
