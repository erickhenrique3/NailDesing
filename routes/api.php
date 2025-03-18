<?php

use Illuminate\Support\Facades\Route;


Route::get('/teste', function () {
  return ([
    'message' => 'Hello World'
  ]);
});