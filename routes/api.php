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

Route::apiResource('/users', UserController::class);
Route::apiResource('/transactions', TransactionController::class,);
Route::put('/transactions/{transaction}/send-for-approval', [TransactionController::class, 'sendForAnalysis']);
Route::get('/accounts/{accountId}', [AccountController::class, 'show']);
Route::get('/health-check', function () {
    return response()->json(['message' => 'success']);
});
