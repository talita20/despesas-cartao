<?php

use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\ExpensesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('/cards', CardController::class);
    Route::apiResource('/expenses', ExpensesController::class);
});

Route::apiResource('/users', UserController::class);

Route::post('/login', [AuthController::class, 'login']);

// Route::post('/login', function (Request $request) {
//     $credentials = $request->only(['email', 'password']);
//     if(Auth::attempt($credentials) === false){
//         return response()->json('Não autorizado', 401);
//     }

//     $user = Auth::user();
//     $token = $user->createToken('token');

//     return response()->json($token->plainTextToken);
// });
