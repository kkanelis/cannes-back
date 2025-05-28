<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\CinemaController;
use Illuminate\Support\Facades\Route;

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);

Route::get('/screening', [ScreeningController::class, 'index']);

Route::get('/cinema', [CinemaController::class, 'index']);