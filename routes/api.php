<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::prefix('v1/users')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::get('/{id}', [UserController::class, 'getUserById']);
});

Route::prefix('v1/transactions')->group(function () {
    Route::post('/new', [TransactionController::class, 'store']);
});

Route::prefix('v1/favoris')->group(callback: function () {
    Route::post('/create', [FavorisController::class, 'store']);
    Route::get('/{userId}', [FavorisController::class, 'findAllByUserId']);
});

Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
});

