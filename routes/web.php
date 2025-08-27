<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\VehicleController;
use App\Models\Vehicle;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/inventories', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/inventories/create', [InventoryController::class, 'create'])->name('inventory.create');
Route::post('/inventories/create', [InventoryController::class, 'store']);
Route::get('/inventories/{inventory}', [InventoryController::class, 'show'])->name('inventory.show');
Route::get('/inventories/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
Route::post('/inventories/{inventory}/edit', [InventoryController::class, 'update']);
Route::get('/inventories/{inventory}/delete', [InventoryController::class, 'destroy'])->name('inventory.destroy');

Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicle.index');
Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicle.create');
Route::post('/vehicles/create', [VehicleController::class, 'store']);
Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicle.show');
Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicle.edit');
Route::post('/vehicles/{vehicle}/edit', [VehicleController::class, 'update']);
