<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserDetailsController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserAuthController;

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
});

// Registration Routes
Route::get('/user/register', [RegisterController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/user/register', [RegisterController::class, 'register'])->name('user.register.post');
//reupload 
Route::post('/user/reupload-proof', [UserController::class, 'updateProofs'])->name('user.reupload.proof');

// Store user details
Route::post('/user/details', [UserDetailsController::class, 'store'])->name('user.details.store');
Route::post('/register', [UserDetailsController::class, 'store'])->name('user.register.submit');
Route::get('/admin/users', [UserDetailsController::class, 'showUsers'])->name('admin.userlist');


// Store all register values
Route::post('register', [UserController::class, 'store'])->name('register.store');

// Logout Route for Admin
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
// Admin Login Route
Route::get('/admin/login', function () {
    return view('admin.login'); // Ensure this view exists in resources/views/admin/login.blade.php
})->name('admin.login');


///popup 
Route::post('/users/update-proof-status', [UserController::class, 'updateProofStatus'])->name('users.update-proof-status');

//reupload
Route::post('/users/reupload-proof', [UserController::class, 'reuploadProof'])->name('users.reupload-proof');


///user login




// Register Routes


Route::get('/user/register', function () {
    return view('user.register');
})->name('user.register');

Route::post('/user/register', [UserDetailsController::class, 'store'])->name('user.register.store');

Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin.users.store');

//register after go to login page for user
Route::get('/user/login', function () {
    return view('user.userlogin');
})->name('user.login');

// Show login form
Route::get('/user/login', [UserLoginController::class, 'showLoginForm'])->name('userlogin');

// Handle login
Route::post('/user/login', [UserLoginController::class, 'store'])->name('userlogin.store');
//user logout 
Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');
Route::get('/userlogin', function () {
    return view('user.userlogin');  // Ensure the correct path
})->name('userlogin');



// User Dashboard (After login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Logout
Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');

// Reupload Proof
Route::post('/users/reupload-proof', [UserController::class, 'reuploadProof'])->name('users.reupload-proof');

// Update Proof Status (For Admin)
Route::post('/users/update-proof-status', [UserController::class, 'updateProofStatus'])->name('users.update-proof-status');


//userlogin in admin page

// User Login Routes
Route::get('/user/login', [UserAuthController::class, 'showLoginForm'])->name('user.login');
Route::post('/user/login', [UserAuthController::class, 'login'])->name('userlogin.store'); 
Route::post('/user/logout', [UserAuthController::class, 'logout'])->name('user.logout');

//delete and deactivate
// Route::post('/users/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
// Route::post('/users/delete', [UserController::class, 'delete'])->name('users.delete');

Route::post('/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');