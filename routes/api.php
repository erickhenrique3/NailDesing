<?php

use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;


Route::get('/teste', function () {
  return ([
    'message' => 'Hello World'
  ]);
});

Route::post('/send-email', [MailController::class, 'send']);
Route::post('/verify-code', [MailController::class, 'verifyCode']);