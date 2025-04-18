<?php

use App\Http\Controllers\ChikhisController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SocialAccountController;
use App\Http\Controllers\API\VideoController;
use App\Http\Controllers\API\ScheduledPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Social accounts
    Route::apiResource('social-accounts', SocialAccountController::class);
    
    // Videos
    Route::apiResource('videos', VideoController::class);
    
    // Scheduled posts
    Route::apiResource('scheduled-posts', ScheduledPostController::class);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('chikhis', ChikhisController::class);
Route::resource('subjects', SubjectsController::class);
Route::resource('tags', TagController::class);



