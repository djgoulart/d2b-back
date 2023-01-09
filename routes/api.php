<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AccountController,
    UserController,
    AuthController,
    TransactionController
};


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/users', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/users/{user}', [UserController::class, 'show']);

    Route::get('/accounts/{accountId}', [AccountController::class, 'show']);

    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show']);
    Route::put('/transactions/{transaction}/send-for-approval', [TransactionController::class, 'sendForAnalysis']);
    Route::post('/transactions/{transaction}/send-image', [TransactionController::class, 'uploadImage']);
});

Route::get('/health-check', function () {
    return response()->json(['message' => 'success']);
});
