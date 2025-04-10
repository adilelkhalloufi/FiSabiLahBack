<?php

use App\Http\Controllers\ChikhisController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\VideosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resource('chikhis', ChikhisController::class);
Route::resource('subjects', SubjectsController::class);
Route::resource('videos', VideosController::class);



