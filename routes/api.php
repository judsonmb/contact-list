<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StateController;

Route::apiResource('contacts', ContactController::class);
Route::get('/states', [StateController::class, 'index']);
