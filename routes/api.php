<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;



Route::prefix('user')->controller(UserController::class)->group(function () {
  Route::middleware('token')->group(function () {
    Route::get('profile', [UserController::class, 'profile']);
    Route::get('logout', [UserController::class, 'logout']);
  });
  Route::post('/', 'create');
  Route::post('/login', 'login');
  Route::get('/', 'index');
  Route::get('/{user}', 'show');
  Route::put('/{user}', 'update');
  Route::delete('/{user}', 'destroy');
});

Route::prefix('service')->controller(ServiceController::class)->group(function () {
  Route::post('/', 'create');
  Route::get('/', 'index');
  Route::get('/{service}', 'show');
  Route::put('/{service}', 'update');
  Route::delete('/{service}', 'destroy');
});