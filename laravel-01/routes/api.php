<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\GoCardlessController;
use App\Http\Controllers\ExampleController;

    // General
    Route::get('/', function () {
        return response()->json("WORKING /api");
    });
    
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('me', [AuthController::class, 'me']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

Route::get('/users/{id}/transactions', [UserController::class, 'getUserTransactions']);
Route::get('/transactions', [TransactionController::class, 'getAllTransactions']);

// Go Cardless Routes
Route::middleware('auth:api')->post('/create-token', [GoCardlessController::class, 'createToken']);

Route::middleware('auth:api')->get('/banks/{country}', [GoCardlessController::class, 'getBanksForCountry']);
Route::middleware('auth:api')->post('/gocardless/agreement', [GoCardlessController::class, 'createAgreement']);

Route::get('/send-message-to-websocket-server', [ExampleController::class, 'connectToWebSocket']);
