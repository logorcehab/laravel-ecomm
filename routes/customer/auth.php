<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\AuthenticatedController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('dashboard', [AuthenticatedController::class, 'dashboard']); 
Route::get('login', [AuthenticatedController::class, 'index'])->name('customer.login.index');
Route::post('login', [AuthenticatedController::class, 'login'])->name('customer.login');
Route::get('verify/{customer:customer_id}', [AuthenticatedController::class, 'verification'])->name('customer.verify.index');
Route::post('verify/{customer:customer_id}', [AuthenticatedController::class, 'verify'])->name('customer.verify');
Route::get('logout', [AuthenticatedController::class, 'signOut'])->name('customer.logout');