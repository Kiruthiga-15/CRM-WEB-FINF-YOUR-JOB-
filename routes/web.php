<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserDetailsController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

// Welcome Page
Route::get('/', function () {
    return view('welcome'); // or redirect('/login');
});

// Admin Login Routes
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Protected Admin Routes
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');

    // AJAX Status Update Route
    Route::post('/admin/users/{id}/update-status', [AdminController::class, 'updateStatus'])->name('admin.users.update-status');

    // **NEW** Proof Status Update Route
  Route::post('/users/update-proof-status', [UserController::class, 'updateProofStatus'])->name('users.update-proof-status');

});

// Registration Routes
Route::get('/user/register', [RegisterController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/user/register', [RegisterController::class, 'register'])->name('user.register.post');

// Reupload Proof Route
Route::post('/user/reupload-proof', [UserController::class, 'updateProofs'])->name('user.reupload.proof');

// Store user details
Route::post('/user/details', [UserDetailsController::class, 'store'])->name('user.details.store');

// Store all register values
Route::post('register', [UserController::class, 'store'])->name('register.store');

// Admin Login Route
Route::get('/admin/login', function () {
    return view('admin.login'); // Ensure this view exists in resources/views/admin/login.blade.php
})->name('admin.login');
