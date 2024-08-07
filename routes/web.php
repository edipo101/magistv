<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('list_accounts');
// });

Route::get('/', [AccountController::class, 'index'])->name('accounts.index');
Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
Route::get('/account_form', [AccountController::class, 'create'])->name('accounts.form');