<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Web\VenueController;
use App\Http\Controllers\Web\EventController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ComputerController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('venues', VenueController::class)->names('venues');
    Route::resource('events', EventController::class)->names('events');
    Route::resource('computers', ComputerController::class)->names('computers');

});
