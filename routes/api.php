<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;



Route::prefix('user')->controller(UserController::class)->group(function () {
  Route::middleware('token')->group(function () {
    Route::get('profile', [UserController::class, 'profile']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::put('/{user}', [UserController::class, 'update']);
  });

  Route::post('/', 'create');
  Route::get('/', 'index');
  Route::get('/{user}', 'show');
  Route::post('/login', 'login');
});

Route::prefix('service')->controller(ServiceController::class)->group(function () {
  Route::middleware('admin')->group(function () {
    Route::post('/', 'create');
    Route::put('/{service}', 'update');
  });
 
  Route::get('/', 'index');
  Route::get('/{service}', 'show');
  
});