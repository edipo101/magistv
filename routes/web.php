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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');

Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
Route::get('/accounts/add-device/{account}', [AccountController::class, 'add_device'])->name('accounts.add_device');
Route::post('/accounts/add-device', [AccountController::class, 'store_add_device'])->name('accounts.store.add_device');
