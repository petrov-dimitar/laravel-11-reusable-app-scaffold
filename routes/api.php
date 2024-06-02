<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

    // General
    Route::get('/', function () {
        return response()->json("WORKING /api");
    });
    
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('me', [AuthController::class, 'me']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);
