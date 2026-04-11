<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\LendingController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
        Route::resource('items', ItemController::class)->except(['create', 'show', 'edit']);
        Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);
        Route::get('/users-admin', [UserController::class, 'admins'])->name('users.index');
        Route::get('/users-user', [UserController::class, 'users'])->name('users.users');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::resource('items', ItemController::class)->except(['show', 'edit']);
        Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
});
    });
});

Route::prefix('operator')->middleware(['auth', 'role:operator'])->group(function() {
    Route::get('lendings', [App\Http\Controllers\Operator\LendingController::class, 'index'])->name('operator.lendings');
    Route::resource('items', ItemController::class)->except(['create', 'show', 'edit']);
    Route::prefix('operator')->middleware(['auth', 'role:operator'])->group(function() {
    Route::get('lendings', [App\Http\Controllers\Operator\LendingController::class, 'index'])->name('operator.lendings');
    Route::post('lendings', [App\Http\Controllers\Operator\LendingController::class, 'store'])->name('operator.lendings.store');
    Route::patch('lendings/{lending}/return', [App\Http\Controllers\Operator\LendingController::class, 'updateReturned'])->name('operator.lendings.return');
    Route::delete('lendings/{lending}', [App\Http\Controllers\Operator\LendingController::class, 'destroy'])->name('operator.lendings.destroy');
});
    

});

Route::get('/operator/lendings', [LendingController::class, 'index']);

Route::put('/lendings/{id}/return', [LendingController::class, 'return'])
    ->name('lendings.return');

Route::delete('/lendings/{id}', [LendingController::class, 'destroy'])
    ->name('lendings.destroy');