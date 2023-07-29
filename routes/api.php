<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\{LoginController, UserController, ProductController};

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


Route::prefix('v1')->group(function () {
    // login
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // users
    Route::resource('users', UserController::class);

    // products
    Route::resource('products', ProductController::class);
});

