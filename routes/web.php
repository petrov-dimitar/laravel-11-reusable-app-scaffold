<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

    // General
    Route::get('/', function () {
        return view('welcome');
    });
    
    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);

    // Swagger
    Route::get('/api/docs', function () {
        $openapi = \OpenApi\Generator::scan([app_path('Http/Controllers')]);
        return response()->json($openapi);
    });
    Route::get('/docs', function () {
        return view('swagger-ui', [
            'urlToDocs' => url('/api/docs')
        ]);
    });
