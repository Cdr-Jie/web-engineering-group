<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    $events = \App\Models\Event::where('visibility', 'public')->get();
    return view('index', ['events' => $events]);
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
    Route::get('/events/{event}/participants', [EventController::class, 'participants'])->name('events.participants');
    Route::post('/events/{event}/registrations/{registration}/attendance', [EventController::class, 'markAttendance'])->name('events.markAttendance');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.my');
    Route::post('/events/register', [EventController::class, 'register'])
        ->name('events.register');
    Route::delete('/events/{event}/unregister', [EventController::class, 'unregister'])
        ->name('events.unregister');
    Route::get('/my-registrations', [EventController::class, 'myRegistrations'])->name('registrations.my');

/* ==============================
    Admin Routes
    ============================= */
    Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');

    Route::middleware('auth')->prefix('/admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        
        // Admin management routes
        Route::get('/admins', [AdminController::class, 'list'])->name('admin.list');
        Route::get('/admins/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/admins', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admin.destroy');
        Route::get('/admins/promote', [AdminController::class, 'showPromoteForm'])->name('admin.promote.form');
        Route::post('/admins/promote', [AdminController::class, 'promoteUserToAdmin'])->name('admin.promote');
        
        // User management routes
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.user.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.user.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.user.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.user.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');
        
        // Event management routes
        Route::get('/events', [AdminController::class, 'events'])->name('admin.events');
        Route::get('/events/create', [AdminController::class, 'createEvent'])->name('admin.event.create');
        Route::post('/events', [AdminController::class, 'storeEvent'])->name('admin.event.store');
        Route::get('/events/{event}/edit', [AdminController::class, 'editEvent'])->name('admin.event.edit');
        Route::put('/events/{event}', [AdminController::class, 'updateEvent'])->name('admin.event.update');
        Route::delete('/events/{event}', [AdminController::class, 'destroyEvent'])->name('admin.event.destroy');
        
        // Event registration management routes
        Route::get('/registrations', [AdminController::class, 'registrations'])->name('admin.registrations');
        Route::get('/registrations/create', [AdminController::class, 'createRegistration'])->name('admin.registration.create');
        Route::post('/registrations', [AdminController::class, 'storeRegistration'])->name('admin.registration.store');
        Route::get('/registrations/{registration}/edit', [AdminController::class, 'editRegistration'])->name('admin.registration.edit');
        Route::put('/registrations/{registration}', [AdminController::class, 'updateRegistration'])->name('admin.registration.update');
        Route::delete('/registrations/{registration}', [AdminController::class, 'destroyRegistration'])->name('admin.registration.destroy');
    });