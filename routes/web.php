<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
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


Route::get('/', [UserController::class, 'index'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.post');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/dashboard', function () { return view('home'); })->name('dashboard')->middleware('auth');

Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
Route::post('/devices/destroy/{id}', [DeviceController::class, 'destroy'])->name('devices.destroy');

Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
Route::get('/accounts/edit/{id}', [AccountController::class, 'edit'])->name('accounts.edit');
Route::post('/accounts/update/{id}', [AccountController::class, 'update'])->name('accounts.update');
Route::get('/accounts/add-device/{account}', [AccountController::class, 'add_device'])->name('accounts.add_device');
Route::post('/accounts/add-device', [AccountController::class, 'store_add_device'])->name('accounts.store.add_device');
Route::post('/accounts/destroy/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');
