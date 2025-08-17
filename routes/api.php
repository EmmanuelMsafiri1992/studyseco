<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes for authentication
Route::post('/register/student', [AuthController::class, 'registerStudent']);
Route::post('/register/teacher', [AuthController::class, 'registerTeacher']);
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1'); // Rate limiting for login
Route::post('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/email/resend', [AuthController::class, 'resendVerificationEmail'])->middleware('throttle:60,1');
Route::post('/phone/verify', [AuthController::class, 'verifyPhoneNumber']);
Route::post('/phone/resend-otp', [AuthController::class, 'resendPhoneOTP']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    // General user routes
    Route::post('/logout', [AuthController::class, 'logout']);

    // User Profile APIs
    Route::prefix('profile')->group(function () {
        Route::get('/', [UserProfileController::class, 'show']);
        Route::post('/update', [UserProfileController::class, 'update']);
        Route::post('/update-parent', [UserProfileController::class, 'updateParentInfo']);
        Route::post('/change-password', [UserProfileController::class, 'changePassword']);
        Route::post('/deactivate', [UserProfileController::class, 'deactivate']);
        Route::post('/avatar', [UserProfileController::class, 'uploadAvatar']);
    });

    // Admin APIs - Requires 'admin' role
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/users', [AdminController::class, 'listUsers']);
        Route::get('/users/{user}', [AdminController::class, 'showUser']);
        Route::post('/users/{user}/role', [AdminController::class, 'assignRole']);
        Route::post('/users/{user}/approve', [AdminController::class, 'approveAccount']);
        Route::post('/users/{user}/reject', [AdminController::class, 'rejectAccount']);
        Route::post('/users/bulk-approve', [AdminController::class, 'bulkApprove']);
    });
});
