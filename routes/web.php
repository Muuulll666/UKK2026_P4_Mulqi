<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Root → redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// -------------------------
// Guest Routes (belum login)
// -------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// -------------------------
// Logout
// -------------------------
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// -------------------------
// Admin Routes
// -------------------------
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

// -------------------------
// User Routes
// -------------------------
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.user');
    })->name('dashboard');
});