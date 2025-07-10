<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\CheckRole;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:ADMIN,MODERATOR'])->group(function (){
    Route::get('/adminmoderator', function () {
        return response()->json(['message' => 'Access granted to ADMIN and MODERATOR']);
    });
});

Route::middleware(['auth:sanctum', 'role:ADMIN'])->group(function () {
    Route::get('/admin', function () {
            return response()->json(['message' => 'Access granted to ADMIN']);
        });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::get('/addresses/{address}', [AddressController::class, 'show']);
    Route::put('/addresses/{address}', [AddressController::class, 'update']);
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy']);

    Route::post('/products', [ProductController::class, 'store']);

    Route::post('/categories', [CategoryController::class, 'store']);
});