<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Operator\LendingController;
use App\Http\Controllers\Operator\ItemController as OperatorItemController;

use Illuminate\Support\Facades\Route;

// Landing
Route::get('/', fn() => view('landing'))->name('landing');

// Auth
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/operator/users/edit', [\App\Http\Controllers\Operator\UserController::class, 'edit'])->name('operator.users.edit');
Route::post('/operator/users/update', [\App\Http\Controllers\Operator\UserController::class, 'update'])->name('operator.users.update');

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
    Route::resource('items', ItemController::class)->except(['create', 'show', 'edit']);
    Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);

    Route::get('users-admin', [UserController::class, 'admins'])->name('users.admins');
    Route::get('users-user', [UserController::class, 'users'])->name('users.users');
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    // Export Users
    Route::get('users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
    Route::get('users/export/pdf', [UserController::class, 'exportPdf'])->name('users.export.pdf');
    Route::get('users/export/operators/excel', [UserController::class, 'exportOperatorsExcel'])->name('users.export.operators.excel');
    Route::get('users/export/operators/pdf', [UserController::class, 'exportOperatorsPdf'])->name('users.export.operators.pdf');
});

// Operator
Route::middleware(['auth', 'role:operator'])->prefix('operator')->name('operator.')->group(function () {
    Route::get('items', [OperatorItemController::class, 'index'])->name('items.index');

    Route::get('lendings', [LendingController::class, 'index'])->name('lendings.index');
    Route::post('lendings', [LendingController::class, 'store'])->name('lendings.store');
    Route::patch('lendings/{lending}/return', [LendingController::class, 'return'])->name('lendings.return');
    Route::delete('lendings/{lending}', [LendingController::class, 'destroy'])->name('lendings.destroy');

    // Export Lendings
    Route::get('lendings/export/excel', [LendingController::class, 'exportExcel'])->name('lendings.export.excel');
    Route::get('lendings/export/pdf', [LendingController::class, 'exportPdf'])->name('lendings.export.pdf');
    Route::get('items/export/excel', [OperatorItemController::class, 'exportExcel'])->name('items.export.excel');
    Route::get('items/export/pdf', [OperatorItemController::class, 'exportPdf'])->name('items.export.pdf');
});
