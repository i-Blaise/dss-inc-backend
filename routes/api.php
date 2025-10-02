<?php

use App\Http\Controllers\API\ContactUsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/contactus', [ContactUsController::class, 'send'])->middleware('throttle:10,1');

