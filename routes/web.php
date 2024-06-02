<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use OpenApi\Attributes as OA;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);

Route::get('/api/docs', function () {
    $openapi = \OpenApi\Generator::scan([app_path('Http/Controllers')]);
    return response()->json($openapi);
});

Route::get('/docs', function () {
    return view('swagger-ui', [
        'urlToDocs' => url('/api/docs')
    ]);
});
