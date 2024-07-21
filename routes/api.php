<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Middleware\AdminCheck;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group( function (){
    
    Route::put('/profile/{profile}/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout']);
});   

Route::get('/profile/{profile}', [ProfileController::class, 'show'])->middleware('auth:sanctum', AdminCheck::class);