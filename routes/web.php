<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\VehicleController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/inventories', [InventoryController::class, 'index']);
Route::get('/inventories/create', [InventoryController::class, 'create']);
Route::post('/inventories/create', [InventoryController::class, 'store']);


Route::get('/vehicles', [VehicleController::class, 'index']);
