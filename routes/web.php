<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
// use App\Http\Controllers\AuthController;
// use App\Http\Controllers\MeterReadingController;

// Route to display the login page
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');

// Route to handle login submission
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
Route::post('/', [CustomerController::class, 'store'])->name('add_customer_details.store');

Route::post('/calculate-billing-details', [CustomerController::class, 'showBillingDetails'])
    ->name('calculate_billing_details');


 
// Route to display the login page
// Route::get('/login', [LoginController::class, 'showLogin'])->name('login');

// // Route to handle login submission
// Route::post('/login', [LoginController::class, 'login'])->name('login');

// // Protected routes accessible only after login
// Route::middleware(['auth'])->group(function () {
//     Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
//     Route::post('/', [CustomerController::class, 'store'])->name('add_customer_details.store');
// });