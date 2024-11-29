<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PixController;

Route::prefix('user')->controller(UserController::class)->group(function () {
  Route::middleware('token')->group(function () {
    Route::get('profile', [UserController::class, 'profile']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::put('/{user}', [UserController::class, 'update']);
    Route::post('/generate-pix', [PixController::class, 'generatePix']);
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

Route::prefix('appointment')->controller(AppointmentController::class)->group(function () {
  Route::post('/', 'create');
  Route::get('/', 'index');
  Route::get('/{appointment}', 'show');
  Route::put('/{appointment}', 'update');
});