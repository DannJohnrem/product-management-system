<?php

use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\ApiProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group( function () {
    Route::post('/login', [ApiLoginController::class, 'store'])->name('api.login');
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('v1')->group( function () {
        Route::apiResource('/products', ApiProductController::class);
    });
});
