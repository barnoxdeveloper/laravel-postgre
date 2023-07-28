<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\UserController;

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


// Route::get('user/{id}', [UserController::class, 'finUserId']);

// Route::resource('user', UserController::class);
Route::resource('user', UserController::class);
// Route::middleware('api')->group(function () {
//     // Other API routes...
// });

// Route::prefix('v1')->group(function () {
//     Route::post('user/login', [UserController::class, 'login']);
// });

