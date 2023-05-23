<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\IncomeController;
use App\Http\Controllers\Api\ExpenseController;

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

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});


Route::middleware('auth:sanctum')->group(function(){

    //Route of Expense
    Route::apiResource('expense', ExpenseController::class);
    Route::delete('expenses', [ExpenseController::class, 'clear'])->name('expense.clear');

    //Route of Income
    Route::apiResource('income', IncomeController::class);
    Route::delete('income', [IncomeController::class, 'clear'])->name('income.clear');
});

