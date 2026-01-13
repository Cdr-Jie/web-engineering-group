<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;


Route::get('/', function () {
    return view('index');
}) -> name('index');

// Registration form
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

// Registration form submission
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Login page
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Login validation
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');

Route::get('/events', [AuthController::class, 'showEventBoard'])->name('events');

// Show form
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

// Handle update
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/my-events', action: fn() => view('events.my'))->name('events.my');


/* ==============================
    Events
    ============================= */
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.my');
    Route::post('/events/register', [EventController::class, 'register'])
        ->name('events.register');
    Route::delete('/events/{event}/unregister', [EventController::class, 'unregister'])
        ->name('events.unregister');

Route::get('/my-registrations', [EventController::class, 'myRegistrations'])->name('registrations.my');
