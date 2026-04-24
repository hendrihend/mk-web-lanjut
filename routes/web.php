<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarketingUserController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [MarketingUserController::class, 'dashboard'])->name('dashboard');
// Routes untuk Marketing Users CRUD
Route::resource('marketing-users', MarketingUserController::class);
// Routes untuk Transactions CRUD
Route::resource('transactions', TransactionController::class);
