<?php

use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\UserController;
use App\Models\Vehicle;
use App\Http\Controllers\APIPostController;

Route::redirect('/', '/home');

// Route::get('/', function () {
//     return view('home');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories.index');
Route::get('/inventories/create', [InventoryController::class, 'create'])->name('inventories.create');
Route::post('/inventories/create', [InventoryController::class, 'store']);
Route::get('/inventories/{inventory}', [InventoryController::class, 'show'])->name('inventories.show');
Route::get('/inventories/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventories.edit');
Route::post('/inventories/{inventory}/edit', [InventoryController::class, 'update']);
// Route::get('/inventories/{inventory}/delete', [InventoryController::class, 'destroy'])->name('inventories.destroy');
Route::delete('/inventories/destroy/{inventory}', [InventoryController::class, 'destroy'])->name('inventories.destroy');

Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
Route::post('/vehicles/create', [VehicleController::class, 'store']);
Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');
Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
Route::post('/vehicles/{vehicle}/edit', [VehicleController::class, 'update']);
Route::delete('/vehicles/destroy/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/create', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/{user}/edit', [UserController::class, 'update']);
Route::delete('/users/destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('posts', [APIPostController::class, 'index'])->name('posts.index');


Route::get('ollama-models',function () {
    $response = Http::get('http://localhost:11434/api/tags');
    $models = $response->json()['models'] ?? []; // extract models array
    return view('ollama-model', compact('models'));
})->name('ollama-models');

Route::get('chat-ollama', function () {
    $response = Http::post('http://localhost:11434/api/generate', [
        'model' => 'gemma3:1b',
        'prompt' => 'Hello, how are you?',
        'stream' => false,
    ]);
    
    $data = $response->json(); // decode JSON
    return view('chat-ollama', compact('data'));
})->name('chat-ollama');

Route::get('/staffs', [StaffController::class, 'index'])->name('staff.index');
