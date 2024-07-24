<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

// Email Verification Notice Route
Route::get('/api/email/verify', function(){
    return response()->json(
        ['message' => 'Please verify your email address.'],
        200
    );
})->middleware('auth:sanctum')->name('verification.notice');

// Email Verification Handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'Email verified successfully.'], 200);
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

// Resending the Verification Email
Route::post('/api/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification link sent!'], 200);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

Route::middleware('auth:sanctum', 'verified')->group( function (){  
    Route::put('/profile/{profile}/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile/{profile}', [ProfileController::class, 'show']);
});   

