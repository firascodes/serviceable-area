<?php

use App\Http\Controllers\CoordinateCheckController;
use App\Http\Controllers\ServiceableAreaController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/serviceable-area', [ServiceableAreaController::class, 'index']);

Route::post('/check-coordinates', [CoordinateCheckController::class, 'check']);

Route::post('/save-serviceable-area', [ServiceableAreaController::class, 'store']);