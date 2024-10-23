<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TransactionController;

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

 // Транзакции
 Route::get('/transactions', [TransactionController::class, 'index']);
 Route::post('/transactions', [TransactionController::class, 'store']);
 Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
 Route::put('/transactions/{id}', [TransactionController::class, 'update']);


