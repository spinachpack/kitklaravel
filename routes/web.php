<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// User routes (protected)
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    
    // Equipment
    Route::get('/equipment', [App\Http\Controllers\User\EquipmentController::class, 'browse'])->name('equipment.browse');
    
    // Bookings
    Route::get('/equipment/{id}/book', [App\Http\Controllers\User\BookingController::class, 'show'])->name('equipment.book');
    Route::post('/equipment/{id}/book', [App\Http\Controllers\User\BookingController::class, 'store'])->name('equipment.book.store');
    Route::get('/bookings', [App\Http\Controllers\User\BookingController::class, 'index'])->name('bookings.index');
    
    // Notifications
    Route::get('/notifications', [App\Http\Controllers\User\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [App\Http\Controllers\User\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::get('/notifications/read-all', [App\Http\Controllers\User\NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    
    // Profile
    Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/picture', [App\Http\Controllers\User\ProfileController::class, 'updatePicture'])->name('profile.picture');
    Route::get('/profile/change-password', [App\Http\Controllers\User\ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::post('/profile/change-password', [App\Http\Controllers\User\ProfileController::class, 'changePassword'])->name('profile.change-password.update');
});

// Admin routes (protected by admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Equipment Management
    Route::get('/equipment', [App\Http\Controllers\Admin\EquipmentController::class, 'index'])->name('equipment.index');
    Route::post('/equipment', [App\Http\Controllers\Admin\EquipmentController::class, 'store'])->name('equipment.store');
    Route::put('/equipment/{id}', [App\Http\Controllers\Admin\EquipmentController::class, 'update'])->name('equipment.update');
    Route::delete('/equipment/{id}', [App\Http\Controllers\Admin\EquipmentController::class, 'destroy'])->name('equipment.destroy');
    
    // Booking Management
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/approve', [App\Http\Controllers\Admin\BookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{id}/reject', [App\Http\Controllers\Admin\BookingController::class, 'reject'])->name('bookings.reject');
    Route::post('/bookings/{id}/complete', [App\Http\Controllers\Admin\BookingController::class, 'complete'])->name('bookings.complete');
    
    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/role', [App\Http\Controllers\Admin\UserController::class, 'changeRole'])->name('users.change-role');
    Route::post('/users/{id}/status', [App\Http\Controllers\Admin\UserController::class, 'changeStatus'])->name('users.change-status');
    
    // Reports
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    
    // Profile
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/picture', [App\Http\Controllers\Admin\ProfileController::class, 'updatePicture'])->name('profile.picture');
    Route::get('/profile/change-password', [App\Http\Controllers\Admin\ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::post('/profile/change-password', [App\Http\Controllers\Admin\ProfileController::class, 'changePassword'])->name('profile.change-password.update');
});

/// Department routes (protected by can.manage.equipment middleware)
Route::middleware(['auth', 'can.manage.equipment'])->prefix('department')->name('department.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Department\DashboardController::class, 'index'])->name('dashboard');
    
    // Equipment Management
    Route::get('/equipment', [App\Http\Controllers\Department\EquipmentController::class, 'index'])->name('equipment.index');
    Route::post('/equipment', [App\Http\Controllers\Department\EquipmentController::class, 'store'])->name('equipment.store');
    Route::put('/equipment/{id}', [App\Http\Controllers\Department\EquipmentController::class, 'update'])->name('equipment.update');
    Route::delete('/equipment/{id}', [App\Http\Controllers\Department\EquipmentController::class, 'destroy'])->name('equipment.destroy');
    
    // Booking Management
    Route::get('/bookings', [App\Http\Controllers\Department\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [App\Http\Controllers\Department\BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/approve', [App\Http\Controllers\Department\BookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{id}/reject', [App\Http\Controllers\Department\BookingController::class, 'reject'])->name('bookings.reject');
    Route::post('/bookings/{id}/complete', [App\Http\Controllers\Department\BookingController::class, 'complete'])->name('bookings.complete');
    
    // Profile
    Route::get('/profile', [App\Http\Controllers\Department\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [App\Http\Controllers\Department\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/picture', [App\Http\Controllers\Department\ProfileController::class, 'updatePicture'])->name('profile.picture');
    Route::get('/profile/change-password', [App\Http\Controllers\Department\ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::post('/profile/change-password', [App\Http\Controllers\Department\ProfileController::class, 'changePassword'])->name('profile.change-password.update');
});